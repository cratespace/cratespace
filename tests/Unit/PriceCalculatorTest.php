<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Space;
use App\Models\Category;
use App\Resources\Payments\Purchase;

class PriceCalculatorTest extends TestCase
{
    /** @test */
    public function it_can_calculate_the_final_price_of_a_space()
    {
        $purchase = new Purchase();
        $purchase->taxRate(5);
        $purchase->serviceRate(10);
        $purchase = $purchase->make(create(Space::class, [
            'price' => 10
        ]));

        $this->assertEquals(0.5, $purchase['tax']);
        $this->assertEquals(1, $purchase['service']);
        $this->assertEquals(11.5, $purchase['total']);
        $this->assertInstanceOf(Space::class, $purchase['space']);
    }
}
