<?php

namespace App\Products;

use App\Contracts\Billing\Product;
use App\Exceptions\InvalidProductException;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Contracts\Foundation\Application;

class Manifest
{
    /**
     * The products storage.
     *
     * @var array
     */
    protected $products = [];

    /**
     * Create new instance of products storage manifest.
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
     * Store a product and record it into the manifest.
     *
     * @param \App\Contracts\Billing\Product|string $product
     *
     * @return void
     */
    public function store($product): void
    {
        if (! is_object($product)) {
            $product = $this->app->make($product);
        }

        if (! $product instanceof Product) {
            throw new InvalidProductException('Not a valid product');
        }

        $this->products[$product->code()] = $product;
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
        if (array_key_exists($code, $this->products)) {
            return $this->get($code);
        }

        throw new ProductNotFoundException("Product with code [{$code}] does not exist or has not been registered");
    }

    /**
     * Get the product instance from storage.
     *
     * @param string $code
     *
     * @return App\Contracts\Billing\Product
     */
    public function get(string $code): Product
    {
        $product = $this->products[$code];

        if (! is_object($product)) {
            return $this->app->make($product);
        }

        return $product;
    }
}
