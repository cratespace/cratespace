<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Orders\ValidateConfirmationNumber;
use App\Contracts\Billing\Order as OrderContract;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
