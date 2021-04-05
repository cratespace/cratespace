<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Orders\ValidateConfirmationNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

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
