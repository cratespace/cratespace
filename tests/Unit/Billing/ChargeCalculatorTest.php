<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use Illuminate\Pipeline\Pipeline;
use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use Illuminate\Database\Eloquent\Model;
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
              'total' => 12.6,
            ],
            $caculator->amounts()
        );
    }

    /**
     * Get charge calculator instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return \App\Contracts\Support\Calculator
     */
    public function getCalculator(Model $resource): Calculator
    {
        return new Calculator($this->getPipeline(), $resource);
    }

    /**
     * Get Laravel pipeline instance.
     *
     * @return \Illuminate\Contracts\Pipeline\Pipeline
     */
    public function getPipeline(): Pipeline
    {
        return app()->make(Pipeline::class);
    }
}
