<?php

namespace App\Contracts\Purchases;

use App\Contracts\Billing\Payment;

interface Order extends Payment
{
    /**
     * Get the product this order belongs to.
     *
     * @return \App\Contracts\Purchases\Product
     */
    public function product(): Product;

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void;
}
