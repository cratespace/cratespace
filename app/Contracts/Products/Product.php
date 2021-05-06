<?php

namespace App\Contracts\Products;

use Stripe\Order;
use App\Contracts\Billing\Payable;
use App\Contracts\Billing\Payment;

interface Product extends Payable
{
    /**
     * Get the product name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * The unique code used to identify the product.
     *
     * @param string $code
     *
     * @return void
     */
    public function setCode(string $code): void;

    /**
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function getCode(): string;

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
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Orders\Order
     */
    public function placeOrder(Payment $payment): Order;

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool;

    /**
     * Determine if the given code matches the product's unique code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products\Product|bool
     */
    public function match(string $code);
}
