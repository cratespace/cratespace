<?php

namespace App\Contracts\Billing;

interface MakesNewPurchases
{
    /**
     * Makes a purchase.
     *
     * @param \App\Contracts\Products\Product|string $product
     * @param array                                  $details
     *
     * @return mixed
     */
    public function purchase($product, array $details);
}
