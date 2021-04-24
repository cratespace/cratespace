<?php

namespace App\Products\Factories;

use App\Contracts\Products\Product;

abstract class Factory
{
    /**
     * Create new product instance.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    abstract public function make(array $data = []): Product;
}
