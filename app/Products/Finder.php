<?php

namespace App\Products;

use App\Contracts\Products\Product;
use App\Contracts\Products\Inventory;
use App\Providers\InventoryServiceProvider;
use App\Exceptions\ProductNotFoundException;
use App\Contracts\Products\Finder as FinderContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Cratespace\Sentinel\Support\Concerns\InteractsWithContainer;

class Finder implements FinderContract
{
    use InteractsWithContainer;

    /**
     * The product inventory instance.
     *
     * @var \App\Contracts\Products\Inventory
     */
    protected $inventory;

    /**
     * Create new ProductFinder instance.
     *
     * @param \App\Contracts\Products\Inventory $inventory
     *
     * @return void
     */
    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Find a product using the given product code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function find(string $code): Product
    {
        if ($product = $this->inventory->get($code, true)) {
            return $product;
        }

        foreach ($this->productLine() as $product) {
            try {
                $product = $this->resolve($product);
            } catch (BindingResolutionException $e) {
                $product = null;
            }

            if (! is_null($product)) {
                return $product->where('code', $code)->first();
            }
        }

        throw new ProductNotFoundException("Product with code [{$code}] not found");
    }

    /**
     * Get Cratespace's product line.
     *
     * @return array
     */
    public function productLine(): array
    {
        return InventoryServiceProvider::productLine();
    }
}
