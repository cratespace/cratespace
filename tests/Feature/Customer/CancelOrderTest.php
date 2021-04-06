<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Support\Money;
use App\Jobs\CancelOrder;
use App\Events\OrderCancelled;
use App\Events\PaymentRefunded;
use App\Services\Stripe\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CancelOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The order customer instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asCustomer()->create();
    }

    public function testOrderCancellation()
    {
        Event::fake();
        Queue::fake();
        Mail::fake();

        $space = create(Space::class);
        $this->signIn($this->user);

        $order = create(Order::class, [
            'orderable_id' => $space,
            'orderable_type' => get_class($space),
            'customer_id' => $this->user->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order));

        $response->assertStatus(303);
    }

    public function testOrderCancellationJobIsQueued()
    {
        Event::fake();
        Queue::fake();
        Mail::fake();

        $space = create(Space::class);
        $this->signIn($this->user);

        $order = create(Order::class, [
            'orderable_id' => $space,
            'orderable_type' => get_class($space),
            'customer_id' => $this->user->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order));

        Queue::assertPushed(CancelOrder::class);

        $response->assertStatus(303);
    }

    public function testOrderCancelledEventTriggeredOnOrderCancellation()
    {
        Mail::fake();
        Event::fake([
            OrderCancelled::class,
            PaymentRefunded::class,
        ]);

        $space = create(Space::class);
        $this->signIn($this->user);

        $order = create(Order::class, [
            'payment' => Payment::create([
                'amount' => 1000,
                'currency' => Money::preferredCurrency(),
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
            ])->id,
            'orderable_id' => $space,
            'orderable_type' => get_class($space),
            'customer_id' => $this->user->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order));

        $response->assertStatus(303);

        Event::assertDispatched(function (OrderCancelled $event) use ($order) {
            return $event->order->is($order);
        });

        $this->assertNull($order->fresh());
    }

    public function testPaymentRefundedEventTriggeredOnOrderCancellation()
    {
        Mail::fake();
        Event::fake([
            OrderCancelled::class,
            PaymentRefunded::class,
        ]);

        $space = create(Space::class);
        $this->signIn($this->user);

        $order = create(Order::class, [
            'payment' => Payment::create([
                'amount' => 1000,
                'currency' => Money::preferredCurrency(),
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
            ])->id,
            'orderable_id' => $space,
            'orderable_type' => get_class($space),
            'customer_id' => $this->user->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order));

        $response->assertStatus(303);

        Event::assertDispatched(function (PaymentRefunded $event) use ($order) {
            return $event->refund->payment_intent === $order->payment->id;
        });
    }
}
