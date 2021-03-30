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
     * Cancel this order.
     *
     * @return void
     */
    public function cancel(): void;
}
