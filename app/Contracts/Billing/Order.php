<?php

namespace App\Contracts\Billing;

interface Order extends Payment
{
    /**
     * Get the product associated with this order.
     *
     * @return \App\Contracts\Billing\Product
     */
    public function product(): Product;

    /**
     * Confirm order for customer.
     *
     * @return void
     */
    public function confirm(): void;

    /**
     * Cancel this order.
     *
     * @return void
     */
    public function cancel(): void;
}
