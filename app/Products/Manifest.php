<?php

namespace App\Products;

use ReflectionClass;
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
     * @param string|null                           $name
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidProductException
     */
    public function store($product, ?string $name = null): void
    {
        if (! is_object($product)) {
            $product = $this->resolve($product, $name);
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
        return $this->resolve(
            $product->productable_type,
            $product->productable_id
        );
    }

    /**
     * Resolve the product instance.
     *
     * @param string $class
     * @param string $id
     *
     * @return \App\Contracts\Billing\Product
     */
    public function resolve(string $class, string $id): Product
    {
        return $this->isModel($class, $id)
            ? $class::findOrFail($id)
            : new $class($id);
    }

    /**
     * Determine if the given class is a model.
     *
     * @param string $class
     * @param string $id
     *
     * @return bool
     */
    protected function isModel(string $class, string $id): bool
    {
        return (new ReflectionClass($class))->isSubclassOf(Model::class) &&
            is_numeric($id);
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
