<?php

namespace App\Billing\PaymentGateways;

use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway implements PaymentGatewayContract
{
    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function total(): int
    {
    }

    /**
     * Charge the customer with the given amount.
     *
     * @param int         $amount
     * @param string      $paymentToken
     * @param string|null $destinationAccountId
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken, ?string $destinationAccountId = null): void
    {
    }

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string
    {
    }
}
