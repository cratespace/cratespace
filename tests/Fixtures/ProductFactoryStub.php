<?php

namespace Tests\Fixtures;

use App\Contracts\Products\Product;
use App\Products\Factories\Factory;

class ProductFactoryStub extends Factory
{
    /**
     * The product the fatory manufactures.
     *
     * @var string
     */
    protected $merchandise = ProductStub::class;

    /**
     * Create new product.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
        $this->product = new ProductStub(
            $data['name'], array_merge(['price' => 1000], $data)
        );

        return $this->product;
    }
}
