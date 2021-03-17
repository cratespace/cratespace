<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use Stripe\StripeClient;
use App\Events\OrderCanceled;
use App\Billing\Stripe\Payment;
use Illuminate\Support\Facades\Event;

class OrderTest extends TestCase
{
    public function testBelongsToSpace()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(Space::class, $order->space);
    }

    public function testCanGetBusinessUser()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withBusiness()->create();
        $space = create(Space::class, ['user_id' => $user->id]);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($order->user->is($user));
    }

    public function testCanGetCustomer()
    {
        $user = User::factory()->asCustomer()->create();
        $order = create(Order::class, ['customer_id' => $user->id]);

        $this->assertTrue($order->customer->is($user));
    }

    public function testOrderCancellation()
    {
        Event::fake();

        $space = create(Space::class);
        $order = create(Order::class, ['space_id' => $space->id]);

        $order->cancel();

        $this->assertNull($space->order);
    }

    public function testOrderCancellationDispatchesEvent()
    {
        Event::fake([
            OrderCanceled::class,
        ]);

        $space = create(Space::class);
        $order = create(Order::class, ['space_id' => $space->id]);

        $order->cancel();

        Event::assertDispatched(function (OrderCanceled $event) use ($order) {
            return $event->order->id === $order->id;
        });

        $this->assertNull($space->order);
    }

    public function testOrderCastsPaymentDetailsToPaymentObject()
    {
        $stripe = new StripeClient(config('billing.secret'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 2000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
        $payment = new Payment($paymentIntent);
        $order = create(Order::class, ['details' => $payment->toArray()]);

        $this->assertInstanceOf(Payment::class, $order->details);
        $this->assertEquals(2000, $order->details->rawAmount());
    }
}
