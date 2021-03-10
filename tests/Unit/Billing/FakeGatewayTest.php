<?php

namespace Tests\Unit\Billing;

use PHPUnit\Framework\TestCase;
use App\Billing\Payments\FakeGateway;

class FakeGatewayTest extends TestCase
{
    public function testChargesWithValidPaymentTokenAreSuccessful()
    {
        $paymentGateway = new FakeGateway();
        $paymentGateway->charge(1250, $paymentGateway->getValidToken());

        $this->assertEquals(1250, $paymentGateway->totalCharges());
        $this->assertTrue($paymentGateway->chargeSuccessful());
    }
}
