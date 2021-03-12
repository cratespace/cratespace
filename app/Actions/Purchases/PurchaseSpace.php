<?php

namespace App\Actions\Purchases;

use App\Contracts\Purchases\Product;
use App\Contracts\Actions\MakesPurchase;

class PurchaseSpace implements MakesPurchase
{
    /**
     * Purchase given product using the given details.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details)
    {
        // code...
    }
}
