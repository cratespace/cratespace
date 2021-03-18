<?php

namespace Tests\Feature\Purchases;

use Tests\TestCase;
use App\Models\Space;
use App\Events\OrderCanceled;
use Tests\Concerns\SupportsPurchase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderCancellationTest extends TestCase
{
    use RefreshDatabase;
    use SupportsPurchase;

    public function testOrderCancellation()
    {
        $user = $this->createCustomer();
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);

        $this->signIn($user);

        $order = $this->makePurchase($space, [
            'name' => $user->name,
            'email' => $user->email,
            'payment_method' => 'pm_card_visa',
            'purchase_token' => $this->generateToken($space),
        ]);

        $this->delete("/orders/{$order->id}");

        $this->assertNull($order->fresh());
    }

    public function testOrderCancellationDispatchesEvent()
    {
        Event::fake([
            OrderCanceled::class,
        ]);

        $user = $this->createCustomer();
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);

        $this->signIn($user);

        $order = $this->makePurchase($space, [
            'name' => $user->name,
            'email' => $user->email,
            'payment_method' => 'pm_card_visa',
            'purchase_token' => $this->generateToken($space),
        ]);

        $this->delete("/orders/{$order->id}");

        Event::assertDispatched(function (OrderCanceled $event) use ($order) {
            return $event->order->id === $order->id;
        });

        $this->assertNull($space->order);
    }
}
