<?php

namespace App\Contracts\Orders;

use App\Contracts\Billing\Payable;
use App\Contracts\Products\Product;
use App\Contracts\Support\Cancellable;

interface Order extends Payable, Cancellable
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
}
