<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Orderable
{
    /**
     * Get the order belonging to the product.
     */
    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'orderable');
    }
}
