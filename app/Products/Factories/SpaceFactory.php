<?php

namespace App\Products\Factories;

use App\Products\Products\Space;
use App\Support\Traits\Fillable;
use App\Contracts\Products\Product;

class SpaceFactory extends Factory
{
    use Fillable;

    /**
     * The product the fatory manufactures.
     *
     * @var string
     */
    protected $product = Space::class;

    /**
     * The instance of the product.
     *
     * @var \App\Contracts\Products\Product
     */
    protected $productInstance;

    /**
     * Create new product instance.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
    }

    /**
     * Parse the data array, filtering out unnecessary data.
     *
     * @param array $data
     *
     * @return array
     */
    public function parseData(array $data): array
    {
        return $this->filterFillable($this->productInstance(), $data);
    }
}
