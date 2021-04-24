<?php

namespace App\Products\Factories;

use App\Products\Products\Space;
use App\Support\Traits\Fillable;
use App\Contracts\Products\Product;

class SpaceFactory extends Factory
{
    use Fillable;

    /**
     * Create new product instance.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
        return new Space();
    }
}
