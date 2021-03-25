<?php

namespace App\Actions\Product;

use LogicException;
use App\Contracts\Billing\Product;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Actions\CreatesNewResources;

class CreateNewProduct implements CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $data
     *
     * @return mixed
     */
    public function create(Model $model, array $data)
    {
        $product = $model::create($data);

        if (! $product instanceof Product) {
            throw new LogicException("Resource with ID [{$product->id}] does not comply with the product contract.");
        }

        return $product;
    }
}
