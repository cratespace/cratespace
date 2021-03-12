<?php

namespace App\Actions\Orders;

use App\Contracts\Purchases\Product;
use App\Contracts\Actions\PlacesOrders;

class PlaceOrder implements PlacesOrders
{
    /**
     * Make order using given details.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    public function make(Product $product, array $details)
    {
        return $product->placeOrder(
            array_merge($details, [
                'price' => $product->price,
                'tax' => $product->tax,
                'total' => $product->fullPrice(),
            ])
        );
    }
}
