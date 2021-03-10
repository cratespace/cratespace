<?php

namespace App\Actions\Orders;

use App\Contracts\Actions\Orders\PlacesOrders;

class PlaceOrder implements PlacesOrders
{
    /**
     * Make order using given details.
     *
     * @param array $details
     * @param mixed $product
     *
     * @return mixed
     */
    public function make(array $details, $product)
    {
        return $product->order()->create(
            array_merge($details, [
                'price' => $product->price,
                'tax' => $product->tax,
                'total' => $product->fullPrice(),
            ])
        );
    }
}
