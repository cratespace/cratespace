<?php

namespace Tests\Unit\Stripe;

use Throwable;
use Tests\TestCase;
use InvalidArgumentException;
use Tests\Fixtures\StripeResourceStub;

/**
 * @group Stripe
 */
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
        $this->withoutExceptionHandling();

        try {
            new StripeResourceStub('id');
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertEquals('Property [mock_reosurce] does not exist within Stripe client', $e->getMessage());

            return;
        }

        $this->fail();
    }
}
