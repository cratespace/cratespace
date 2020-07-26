<?php

namespace App\Billing\PaymentGateways;

use Illuminate\Support\Str;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Create new instance of fake payment gateway.
     */
    public function __construct()
    {
        $this->testToken = Str::random(40);

        parent::__construct();
    }

    /**
     * Charge the customer with the given amount.
     *
     * @param int    $amount
     * @param string $paymentToken
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken): void
    {
        if ($paymentToken !== $this->getValidTestToken()) {
            throw new PaymentFailedException('Invalid payment token.');
        }

        $this->charges[] = $amount;

        $this->totalCharges = $this->charges->sum();
    }

    /**
     * Generate fake payment token for testing.
     *
     * @return string
     */
    public function getValidTestToken(): string
    {
        return $this->testToken;
    }
}
