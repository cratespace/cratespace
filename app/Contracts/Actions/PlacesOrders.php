<?php

namespace App\Contracts\Actions;

use App\Contracts\Purchases\Product;

interface PlacesOrders
{
    /**
     * Make order using given details.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    public function make(Product $product, array $details);
}
