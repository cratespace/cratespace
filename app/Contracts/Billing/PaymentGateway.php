<?php

namespace App\Contracts\Billing;

interface PaymentGateway
{
    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function totalCharges(): int;

    /**
     * Charge the customer with the given amount.
     *
     * @param int    $amount
     * @param string $paymentToken
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken): void;

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string;
}
