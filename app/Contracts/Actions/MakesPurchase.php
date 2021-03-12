<?php

namespace App\Contracts\Actions;

use App\Contracts\Purchases\Product;

interface MakesPurchase
{
    /**
     * Purchase given product using the given details.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details);
}
