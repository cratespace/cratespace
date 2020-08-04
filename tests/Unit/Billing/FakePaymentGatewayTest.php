<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\PaymentGateways\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    /**
     * ID of latest charge made.
     *
     * @var string
     */
    protected $lastChargeId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->performFirstCharge();
    }

    /** @test */
    public function charges_with_a_valid_payment_token_are_successful_fake()
    {
        $newPaymentGateway = $this->getPaymentGateway();

        $newPaymentGateway->charge(2500, $newPaymentGateway->generateToken([]));

        $this->assertEquals(2500, $newPaymentGateway->totalCharges());
    }

    /**
     * Get instance of payment gateway.
     *
     * @return \App\Contracts\Billing\PaymentGateway
     */
    protected function getPaymentGateway()
    {
        return new FakePaymentGateway();
    }

    /**
     * Get test credit card details.
     *
     * @return array
     */
    protected function getCardDetails(): array
    {
        return [];
    }
}
