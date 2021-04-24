<?php

namespace App\Products\Factories;

use RuntimeException;
use App\Contracts\Products\Product;
use App\Support\Concerns\InteractsWithContainer;

abstract class Factory
{
    use InteractsWithContainer;

    /**
     * The product the fatory manufactures.
     *
     * @var string
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

    /**
     * Get an instance of the product.
     *
     * @return \App\Contracts\Products\Product
     */
    public function productInstance(): Product
    {
        if (is_null($this->productInstance)) {
            $this->productInstance = $this->createProductInstance();
        }

        return $this->productInstance;
    }

    /**
     * Create an instance of the manufacturable product.
     *
     * @return \App\Contracts\Products\Product
     */
    public function createProductInstance(): Product
    {
        if (! is_null($this->product)) {
            return $this->resolve($this->product);
        }

        throw new RuntimeException('Product class not set');
    }
}
