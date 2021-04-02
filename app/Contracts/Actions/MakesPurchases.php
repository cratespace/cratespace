<?php

namespace App\Contracts\Actions;

use App\Contracts\Billing\Product;

interface MakesPurchases
{
    /**
     * Purchase the given product using the given details.
     *
     * @param \App\Contracts\Billing\Product $product
     * @param array                          $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details);
}
