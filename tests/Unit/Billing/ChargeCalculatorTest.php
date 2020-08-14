<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use Tests\Unit\Billing\fixtures\PriceableResourceMock;
use App\Contracts\Support\Calculator as CalculatorContract;

class ChargeCalculatorTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $resource = new PriceableResourceMock();
        $caculator = new Calculator($this->getPipeline(), $resource);

        $this->assertInstanceOf(CalculatorContract::class, $caculator);
        $this->assertInstanceOf(Priceable::class, $caculator->resource());
    }

    /** @test */
    public function it_can_get_charges_of_provided_resource()
    {
        $caculator = $this->getCalculator(new PriceableResourceMock());

        $this->assertEquals(['price' => 10, 'tax' => 2], $caculator->resourceCharges());
    }

    /** @test */
    public function it_can_calculate_charges_of_provided_resource()
    {
        $caculator = $this->getCalculator(new PriceableResourceMock());
        $caculator->calculate();

        $this->assertEquals(
            [
                'price' => 10,
                'tax' => 0.24,
                'subtotal' => 12,
                'service' => 0.36,
                'total' => 12,
            ],
            $caculator->amounts()
        );
    }
}
