<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\PaymentGateways\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
    /** @test */
    public function it_accepts_charges_with_a_valid_payment_token()
    {
        $paymentGateway = new FakePaymentGateway();

        $paymentGateway->charge(2500, $paymentGateway->generateToken($this->getCardDetails()));

        $this->assertEquals(2500, $paymentGateway->total());
    }

    /** @test */
    public function it_can_generate_and_validate_a_testing_payment_token()
    {
        $paymentGateway = new FakePaymentGateway();

        $token = $paymentGateway->generateToken($this->getCardDetails());

        $this->assertTrue($paymentGateway->matches($token));
    }

    /** @test */
    // public function It_can_run_a_hook_before_the_first_charge()
    // {
    //     $paymentGateway = new FakePaymentGateway();
    //     $timesCallbackRan = 0;

    //     $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$timesCallbackRan) {
    //         $paymentGateway->charge(1200, $paymentGateway->generateToken($this->getCardDetails()));

    //         ++$timesCallbackRan;

    //         $this->assertEquals(1200, $paymentGateway->total());
    //     });

    //     $paymentGateway->charge(1200, $paymentGateway->generateToken($this->getCardDetails()));
    //     $this->assertEquals(1, $timesCallbackRan);
    //     $this->assertEquals(2400, $paymentGateway->total());
    // }

    /**
     * Get fake credit card details.
     *
     * @return array
     */
    protected function getCardDetails(): array
    {
        return [
            'number' => FakePaymentGateway::TEST_CARD_NUMBER,
        ];
    }
}
