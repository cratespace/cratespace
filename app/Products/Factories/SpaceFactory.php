<?php

namespace App\Products\Factories;

use Throwable;
use App\Products\Line\Space;
use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Crypt;
use Cratespace\Sentinel\Support\Traits\Fillable;

class SpaceFactory extends Factory
{
    use Fillable;

    /**
     * Create new product.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
        $product = new Space($data);

        $this->product = with($product->create(
            array_merge($this->parse($data), [
                'user_id' => auth()->id(),
            ])
        ), function (Product $product): Product {
            try {
                $product->getCode();
            } catch (Throwable $e) {
                $product->setCode(Crypt::encrypt(
                    get_class($product) . '-' . $product->getName()
                ));
            }

            return $product;
        });

        return $this->product;
    }

    /**
     * Parse the data array, filtering out unnecessary data.
     *
     * @param array $data
     *
     * @return array
     */
    public function parse(array $data): array
    {
        return $this->filterFillable($data, Space::class);
    }
}
