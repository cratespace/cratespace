<?php

namespace App\Products;

use InvalidArgumentException;
use App\Contracts\Products\Product;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use App\Contracts\Products\Inventory as InventoryContract;

class Inventory implements InventoryContract
{
    /**
     * The Cratespace application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create new ProductInventory instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Store a product inside the inventory.
     *
     * @param \App\Contracts\Products\Product|string $product
     * @param array|null                             $parameters
     *
     * @return mixed
     */
    public function store($product, ?array $parameters = null)
    {
        if (is_string($product) && ! is_null($parameters)) {
            $product = $this->app->make($product, $parameters);
        }

        if (! $product instanceof Model) {
            $this->app->instance(
                $this->normalizeAlias($product->getCode()),
                $product
            );

            return $product;
        }

        throw new InvalidArgumentException('Product cannot be stored');
    }

    /**
     * Get a product out of the inventory.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products\Product|null
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function get(string $code, bool $queitly = false): ?Product
    {
        $alias = $this->normalizeAlias($code);

        $product = $this->app->has($alias)
            ? $this->app->get($alias)
            : null;

        if (! is_null($product) && $product->match($code)) {
            return $product;
        }

        if ($queitly) {
            return null;
        }

        throw new ProductNotFoundException("Product with code [{$code}] was not found in the inventory");
    }

    /**
     * Create an alias for the product to be bound inside the service container with.
     *
     * @param string $code
     *
     * @return string
     */
    protected function normalizeAlias(string $code): string
    {
        return "product.{$code}";
    }
}
