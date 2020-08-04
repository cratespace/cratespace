<?php

namespace Tests\Unit\Billing;

use App\Exceptions\PaymentFailedException;

trait PaymentGatewayContractTest
{
    /**
     * Perform initial charge action.
     *
     * @return void
     */
    protected function performFirstCharge(): void
    {
        $paymentGatewayFirst = $this->getPaymentGateway();

        $paymentGatewayFirst->charge(2400, $paymentGatewayFirst->generateToken($this->getCardDetails()));

        $this->lastChargeId = $paymentGatewayFirst->charges()->last()->id;
    }

    /** @test */
    public function it_has_a_test_card_number()
    {
        $this->assertEquals(
            $this->getPaymentGateway()::TEST_CARD_NUMBER,
            '4242424242424242'
        );
    }

    /** @test */
    public function charges_with_an_invalid_payment_token_fail()
    {
        try {
            $paymentGateway = $this->getPaymentGateway();
            $paymentGateway->charge(2500, 'invalid-payment-token');
        } catch (PaymentFailedException $e) {
            $this->assertEquals(2500, $e->chargedAmount());
            $this->assertInstanceOf(PaymentFailedException::class, $e);
            $this->assertCount(0, $paymentGateway->newChargesSince($this->lastChargeId));

            return;
        }

        $this->fail('Charging with an invalid payment token did not throw an PaymentFailedException.');
    }

    /** @test */
    public function It_can_run_a_hook_before_the_first_charge()
    {
        $paymentGateway = $this->getPaymentGateway();
        $timesCallbackRan = 0;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan) {
            $paymentGateway->charge(1200, $paymentGateway->generateToken($this->getCardDetails()));

            ++$timesCallbackRan;

            $this->assertEquals(1200, $paymentGateway->totalCharges());
        });

        $paymentGateway->charge(
            1200,
            $paymentGateway->generateToken($this->getCardDetails())
        );
        $this->assertEquals(1, $timesCallbackRan);
        $this->assertEquals(2400, $paymentGateway->totalCharges());
    }
}
