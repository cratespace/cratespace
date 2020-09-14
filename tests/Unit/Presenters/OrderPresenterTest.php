<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Support\Formatter;

class OrderPresenterTest extends TestCase
{
    /** @test */
    public function it_can_display_order_charge_information_in_money_format()
    {
        $space = create(Space::class, ['price' => 12.3]);
        $price = $space->price;
        $total = $price + ($price * 0.03);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'price' => $price,
            'tax' => 0,
            'subtotal' => $subtotal = $space->price + $space->tax,
            'service' => $price * 0.03,
            'total' => $total,
        ]);

        $presentableTotal = Formatter::money($total);
        $presentableTax = Formatter::money($order->tax + $space->tax);
        $presentableSubTotal = Formatter::money($subtotal);
        $presentablePrice = Formatter::money($price);

        $this->assertEquals($presentableTotal, $order->present()->total);
        $this->assertTrue(is_string($order->present()->total));
        $this->assertEquals($presentableSubTotal, $order->present()->subtotal);
        $this->assertTrue(is_string($order->present()->subtotal));
        $this->assertEquals($presentablePrice, $order->present()->price);
        $this->assertTrue(is_string($order->present()->price));
        $this->assertEquals($presentableTax, $order->present()->tax);
        $this->assertTrue(is_string($order->present()->tax));
    }
}
