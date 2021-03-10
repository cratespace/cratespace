<?php

namespace App\Contracts\Actions\Orders;

interface PlacesOrders
{
    /**
     * Make order using given details.
     *
     * @param array $details
     * @param mixed $product
     *
     * @return mixed
     */
    public function make(array $details, $product);
}
