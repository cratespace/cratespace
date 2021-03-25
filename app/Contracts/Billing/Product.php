<?php

namespace App\Contracts\Billing;

interface Product
{
    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant();

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void;

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void;

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
