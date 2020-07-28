<?php

namespace Tests\Unit\Billing;

use PHPUnit\Framework\TestCase;
use App\Exceptions\PaymentFailedException;
use App\Billing\PaymentGateways\FakePaymentGateway;

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
    public function it_has_a_test_card_number()
    {
        $this->assertEquals(FakePaymentGateway::TEST_CARD_NUMBER, 4242424242424242);
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

    /** @test */
    public function It_can_run_a_hook_before_the_first_charge()
    {
        $paymentGateway = new FakePaymentGateway();
        $timesCallbackRan = 0;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan) {
            $paymentGateway->charge(1200, $paymentGateway->getValidTestToken());

            ++$timesCallbackRan;

            $this->assertEquals(1200, $paymentGateway->totalCharges());
        });

        $paymentGateway->charge(1200, $paymentGateway->getValidTestToken());
        $this->assertEquals(1, $timesCallbackRan);
        $this->assertEquals(2400, $paymentGateway->totalCharges());
    }
}
