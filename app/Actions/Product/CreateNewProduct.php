<?php

namespace App\Actions\Product;

use LogicException;
use App\Contracts\Billing\Product;
use App\Contracts\Actions\CreatesNewResources;

class CreateNewProduct implements CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param mixed $model
     * @param array $data
     *
     * @return mixed
     */
    public function create($model, array $data)
    {
        if (! (new $model()) instanceof Product) {
            throw new LogicException("Model class [{$model}] does not comply with the product contract");
        }

        $product = $model::create($data);

        return $product;
    }
}
