<?php

namespace App\Actions\Product;

use Throwable;
use LogicException;
use App\Products\Manifest;
use App\Contracts\Billing\Product;
use App\Contracts\Actions\CreatesNewResources;

class CreateNewProduct implements CreatesNewResources
{
    /**
     * The product store manifest instance.
     *
     * @var \App\Products\Manifest
     */
    protected $manifest;

    /**
     * Create new product creator instance.
     *
     * @param \App\Products\Manifest $manifest
     */
    public function __construct(Manifest $manifest)
    {
        $this->manifest = $manifest;
    }

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
        try {
            $product = $resource::create($data);
        } catch (Throwable $e) {
            $product = $this->manifest->resolve($resource, $data['name']);
        }

        if (! $product instanceof Product) {
            throw new LogicException("Model class [{$resource}] does not comply with the product contract");
        }

        $this->manifest->store($product, $data['name'] ?? null);

        return $product;
    }
}
