<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use ReflectionClass;
use App\Models\Space;
use App\Contracts\Billing\Charges;
use App\Billing\Charges\Calculator;

class CalculatorTest extends TestCase
{
    /** @test */
    public function it_only_accepts_resources_that_adhere_to_priceable_interface()
    {
        $space = create(Space::class);

        $chargesCalculator = new Calculator($space);

        $this->assertSame($space, $chargesCalculator->getResource());
    }

    /** @test */
    public function it_has_a_collection_of_all_charges_to_be_calculated()
    {
        $space = create(Space::class);

        $chargesCalculator = new Calculator($space);

        $this->assertTrue(is_array($chargesCalculator->getCharges()));

        foreach ($chargesCalculator->getCharges() as $charges) {
            $reflection = new ReflectionClass($charges);

            $this->assertTrue($reflection->implementsInterface(Charges::class));
        }
    }

    /** @test */
    public function it_can_calculate_all_listed_charges_for_given_resource()
    {
        $space = create(Space::class);

        $chargesCalculator = new Calculator($space);

        $charges = $chargesCalculator->calculateCharges();

        $this->assertTrue(is_array($charges));
        $this->assertSame($charges, cache('charges'));
        $this->assertArrayHasKey('subtotal', $charges);
        $this->assertArrayHasKey('service', $charges);
        $this->assertArrayHasKey('total', $charges);
        $this->assertArrayHasKey('tax', $charges);
    }
}
