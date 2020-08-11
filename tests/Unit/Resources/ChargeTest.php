<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

class ChargeTest extends TestCase
{
    /** @test */
    public function it_belongs_to_an_order()
    {
        $space = create(Space::class);
        $this->calculateCharges($space);
        $order = $space->placeOrder($this->orderDetails());
        $charge = $order->charge()->create([
            'amount' => $order->total,
            'card_last_four' => '4242',
            'details' => 'local',
        ]);

        $this->assertEquals($order->id, $charge->order->id);
        $this->assertInstanceOf(Order::class, $charge->order);
    }
}
