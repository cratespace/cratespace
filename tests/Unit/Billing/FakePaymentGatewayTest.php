<?php

namespace Tests\Unit\Billing;

use PHPUnit\Framework\TestCase;
use App\Billing\FakePaymentGateway;
use App\Exceptions\PaymentFailedException;

class FakePaymentGatewayTest extends TestCase
{
    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new FakePaymentGateway();

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2500, $paymentGateway->totalCharges());
    }

    /** @test */
    public function charges_with_an_invalid_payment_token_fail()
    {
        try {
            $paymentGateway = new FakePaymentGateway();
            $paymentGateway->charge(2500, 'invalid-payment-token');
        } catch (PaymentFailedException $e) {
            // $this->assertEquals(2500, $e->chargedAmount());
            // $this->assertInstanceOf(PaymentFailedException::class, $e);
            return $this->assertTrue(true);
        }

        $this->fail();
    }
}
