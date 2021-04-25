<?php

namespace App\Contracts\Products;

use App\Contracts\Orders\Order;
use App\Contracts\Billing\Payment;

interface Product
{
    /**
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function code(): string;

    /**
     * The name used to identify the product.
     *
     * @return string
     */
    public function name(): string;

    /**
     * The unique code used to identify the product.
     *
     * @param string $code
     *
     * @return void
     */
    public function setCode(string $code): void;

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
     * Get full amount inclusive of tax for product in integer value.
     *
     * @return int
     */
    public function fullAmount(): int;

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
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array;

    /**
     * Get the order associated with the product.
     *
     * @return mixed
     */
    public function order();

    /**
     * Determine if the product is nearing it's expiration.
     *
     * @return bool
     */
    public function nearingExpiration(): bool;
}
