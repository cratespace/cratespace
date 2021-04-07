<?php

namespace App\Products;

use Throwable;
use App\Models\Product as Store;
use App\Contracts\Billing\Product;
use App\Exceptions\InvalidProductException;
use App\Exceptions\ProductNotFoundException;

class Manifest
{
    /**
     * The product storage instance.
     *
     * @var \App\Models\Product
     */
    protected $store;

    /**
     * Create new instance of products storage manifest.
     *
     * @param \App\Models\Product $store
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Store a product and record it into the manifest.
     *
     * @param \App\Contracts\Billing\Product|string $product
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidProductException
     */
    public function store($product): void
    {
        if (! is_object($product)) {
            $product = app($product);
        }

        if (! $product instanceof Product) {
            $product = get_class($product);

            throw new InvalidProductException("Product [{$product}] is not a valid product");
        }

        if (! $this->store->has($product)) {
            $this->store->create($this->details($product));
        }
    }

    /**
     * Find a product within the storage manifest.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function match(string $code): Product
    {
        if ($product = $this->store->findUsingCode($code)) {
            return $this->get($product);
        }

        throw new ProductNotFoundException("Product with code [{$code}] does not exist or has not been registered");
    }

    /**
     * Get the product instance from storage.
     *
     * @param \App\Models\Product $product
     *
     * @return App\Contracts\Billing\Product
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(Store $product): Product
    {
        $hasName = ! is_numeric($product->productable_id);

        if ($hasName) {
            return app()->make($product->productable_type, [
                'name' => $product->productable_id,
            ]);
        }

        return ($product->productable_type)::findOrFail($product->productable_id);
    }

    /**
     * Get instance of product storage.
     *
     * @return \App\Models\Product
     */
    public function storage(): Store
    {
        return $this->store;
    }

    /**
     * Get product details for registration.
     *
     * @param \App\Contracts\Billing\Product $product
     *
     * @return array
     */
    protected function details(Product $product): array
    {
        return [
            'code' => $product->code(),
            'productable_id' => $product->name(),
            'productable_type' => get_class($product),
        ];
    }
}
