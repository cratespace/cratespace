<?php

namespace App\Products\Factories;

use Throwable;
use Illuminate\Support\Str;
use App\Products\Line\Space;
use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Crypt;
use Cratespace\Preflight\Support\HashId;
use Cratespace\Sentinel\Support\Traits\Fillable;

class SpaceFactory extends Factory
{
    use Fillable;

    /**
     * The instance of the product being manufactured.
     *
     * @var \App\Contracts\Products\Product|null
     */
    protected $product = Space::class;

    /**
     * Create new product.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
        $product = $this->createProductInstance($data);

        return with($product, function (Product $product): Product {
            try {
                $product->getCode();
            } catch (Throwable $e) {
                $product->setCode(Str::upper(HashId::generate($product->id)));
            }

            return $product;
        });
    }

    /**
     * Create an instance of the product.
     *
     * @param array $attributes
     *
     * @return \App\Contracts\Products\Product
     */
    public function createProductInstance(array $attributes): Product
    {
        if (is_null($this->product) || ! $this->product instanceof Product) {
            $this->product = Space::create(
                $this->filterFillable($attributes, $this->product)
            );
        }

        return $this->product;
    }
}
