<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Events\OrderCancelled;
use App\Contracts\Billing\Payment;
use Illuminate\Support\Facades\Event;
use App\Orders\ValidateConfirmationNumber;
use App\Contracts\Billing\Order as OrderContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(OrderContract::class, $order);
    }

    public function testOrderBelongsToBusiness()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(User::class, $order->business);
    }

    public function testOrderBelongsToCustomer()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(User::class, $order->customer);
    }

    public function testOrderAmountInCents()
    {
        $order = create(Order::class, ['amount' => 1000]);

        $this->assertEquals('$10.00', $order->amount());
    }

    public function testOrderPresentableAmountInCents()
    {
        $order = create(Order::class, ['amount' => 1000]);

        $this->assertEquals(1000, $order->rawAmount());
    }

    public function testConfirmOrder()
    {
        $order = create(Order::class);

        $order->confirm();

        $this->assertTrue($order->confirmed());
    }

    public function testValidateOrderConfirmation()
    {
        $order = create(Order::class);

        $order->confirm();

        $validator = new ValidateConfirmationNumber();

        $this->assertTrue($validator->validate($order->confirmation_number));
    }

    public function testOrderCancellation()
    {
        Event::fake();

        $order = create(Order::class);

        $order->cancel();

        Event::assertDispatched(function (OrderCancelled $event) use ($order) {
            return $event->order->is($order);
        });
    }

    public function testOrderCancellationReleasesProduct()
    {
        Event::fake();

        $order = create(Order::class);

        $this->assertFalse($order->orderable->available());

        $order->cancel();

        $this->assertTrue($order->orderable->available());
    }

    public function testOrderCastsPaymentDetailsToPaymentObject()
    {
        $order = create(Order::class);

        $this->assertInstanceOf(Payment::class, $order->payment);
    }

    public function testRetrievingAnOrderByConfirmationNumber()
    {
        $order = create(Order::class, [
            'confirmation_number' => 'ORDERCONFIRMATION1234',
        ]);

        $foundOrder = Order::findByConfirmationNumber('ORDERCONFIRMATION1234');

        $this->assertEquals($order->id, $foundOrder->id);
    }

    public function testRetrievingANonexistentOrderByConfirmationNumberThrowsAnException()
    {
        $this->expectException(ModelNotFoundException::class);
        Order::findByConfirmationNumber('NONEXISTENTCONFIRMATIONNUMBER');
    }
}
