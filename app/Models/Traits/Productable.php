<?php

namespace App\Models\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Productable
{
    /**
     * Get the product belonging to the model.
     */
    public function product(): MorphOne
    {
        return $this->morphOne(Product::class, 'productable');
    }
}
