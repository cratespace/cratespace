<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Support\Formatter;

class OrderPresenterTest extends TestCase
{
    /** @test */
    public function it_can_display_order_total_information_in_money_format()
    {
        $space = create(Space::class, ['price' => 12.3]);
        $price = $space->price;
        $total = $price + ($price * 0.03);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'price' => $price,
            'tax' => 0,
            'service' => $price * 0.03,
            'total' => $total,
        ]);

        $presentableTotal = Formatter::money($total);

        $this->assertEquals($presentableTotal, $order->present()->total);
        $this->assertTrue(is_string($order->present()->total));
    }
}
