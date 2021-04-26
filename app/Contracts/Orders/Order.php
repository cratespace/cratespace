<?php

namespace App\Contracts\Orders;

use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;

interface Order extends Payment
{
    /**
     * Get the product associated with this order.
     *
     * @return \App\Contracts\Products\Product
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