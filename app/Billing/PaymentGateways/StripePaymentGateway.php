<?php

namespace App\Billing\PaymentGateways;

use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class StripePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = 4242424242424242;

    /**
     * List of fake payment tokens.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $tokens;

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
    }
}
