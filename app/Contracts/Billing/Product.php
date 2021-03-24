<?php

namespace App\Contracts\Billing;

interface Product
{
    /**
     * Get full price of product in integer value.
     *
     * @return int
     */
    public function fullPrice(): int;

    /**
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Billing\Order
     */
    public function placeOrder(Payment $payment): Order;

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool;
}
