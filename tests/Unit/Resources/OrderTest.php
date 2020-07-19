<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_calculate_total_amount_and_present_in_currency_format()
    {
        config()->set('charges.service', 0.5);

        $space = create(Space::class, ['price' => 32.50, 'tax' => .50]);
        $order = create(Order::class, [
            'space_id' => $space->id,
            'price' => $space->getPriceInCents(),
            'tax' => $space->getTaxInCents(),
        ]);

        $this->assertTrue(is_string($order->total));
        $this->assertEquals('$49.50', $order->total);
    }
}
