<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\PaymentGateways\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->performFirstCharge();
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
