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
     * @param mixed $resource
     * @param array $data
     *
     * @return mixed
     */
    public function create($resource, array $data)
    {
        if (! (new $resource()) instanceof Product) {
            throw new LogicException("Model class [{$resource}] does not comply with the product contract");
        }

        $product = $resource::create($data);

        return $product;
    }
}
