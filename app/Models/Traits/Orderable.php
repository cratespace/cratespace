<?php

namespace App\Models\Traits;

use App\Models\Order;

trait Orderable
{
    /**
     * Get the order associated with the product.
     *
     * @return mixed
     */
    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }
}
