<?php

namespace App\Contracts\Billing;

use App\Contracts\Products\Product;

interface MakesPurchases
{
    /**
     * Makes a purchase.
     *
     * @param \App\Contracts\Products\Product $product
     * @param array                           $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details);
}
