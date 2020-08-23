<?php

namespace App\Contracts\Billing;

use App\Models\Order;

interface PaymentGateway
{
    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function total(): int;

    /**
     * Charge the customer with the given amount.
     *
     * @param \App\Models\Order $order
     * @param string            $paymentToken
     *
     * @return void
     */
    public function charge(Order $order, string $paymentToken): void;

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string;
}
