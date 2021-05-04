<?php

namespace App\Products\Factories;

use App\Contracts\Products\Product;
use Cratespace\Sentinel\Support\Concerns\InteractsWithContainer;

abstract class Factory
{
    use InteractsWithContainer;

    /**
     * The instance of the product being manufactured.
     *
     * @var \App\Contracts\Products\Product|null
     */
    protected $product;

    /**
     * Create new product.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    abstract public function make(array $data = []): Product;
}
