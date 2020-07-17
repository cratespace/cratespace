<?php

namespace App\Billing;

use Illuminate\Support\Str;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
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
        return Str::random(40);
    }
}
