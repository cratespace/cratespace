<?php

namespace App\Products;

use App\Models\Product as Store;
use App\Contracts\Billing\Product;
use Illuminate\Database\Eloquent\Model;
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
     */
    public function store($product): void
    {
        if (! is_object($product)) {
            $product = app($product);
        }

        if (! $product instanceof Product) {
            throw new InvalidProductException('Not a valid product');
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
     */
    public function get(Store $product): Product
    {
        $class = app($product->productable_type);

        if (! is_null($product->productable_id) && $product instanceof Model) {
            return get_class($class)::findOrFail($product->productable_id);
        }

        return $class;
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
            'productable_id' => $product->id ?? null,
            'productable_type' => get_class($product),
        ];
    }
}