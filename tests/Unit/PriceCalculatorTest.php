<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Space;
use App\Calculators\Purchase;

class PriceCalculatorTest extends TestCase
{
    /** @test */
    public function it_can_calculate_the_final_price_of_a_space()
    {
        $purchase = new Purchase();
        $space = create(Space::class, ['price' => 10]);

        $this->assertEquals(
            [
                "subtotal" => 10,
                "service" => 1,
                "tax" => 0.5,
                "total" => 11.5,
            ],
            $purchase->calculate($space->price)->getAmounts()
        );
    }
}
