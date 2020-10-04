<?php

namespace App\Contracts\Actions;

use App\Models\Order;
use App\Models\Space;

interface CreatesNewOrders
{
    /**
     * Create new order.
     *
     * @param \App\Models\Space $space
     * @param array             $data
     *
     * @return \App\Models\Order
     */
    public function create(Space $space, array $data): Order;
}
