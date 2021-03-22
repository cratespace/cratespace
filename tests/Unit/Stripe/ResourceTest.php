<?php

namespace Tests\Unit\Stripe;

use Throwable;
use Tests\TestCase;
use InvalidArgumentException;
use Tests\Unit\Models\StripeResourceStub;

class ResourceTest extends TestCase
{
    public function testFilterAllowableAttributes()
    {
        $this->assertEquals(['name' => 'ResourceAttribute'], StripeResourceStub::fillable([
            'uid' => 'sadhlaudhawu7fgwoei73ad',
            'payment_method' => 'pm_card_visa',
            'name' => 'ResourceAttribute',
        ]));
    }

    public function testDynamicallyGetResourceAttributesAndServices()
    {
        try {
            new StripeResourceStub('id');
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertEquals('Property [mock_reosurce] does not exist within Stripe client', $e->getMessage());
        }
    }
}