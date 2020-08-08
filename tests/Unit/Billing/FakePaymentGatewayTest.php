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
