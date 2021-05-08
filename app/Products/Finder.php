<?php

namespace App\Products;

use App\Contracts\Products\Product;
use App\Contracts\Products\Inventory;
use Illuminate\Database\Eloquent\Model;
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
        if ($this->inventory->has($code)) {
            return $this->inventory->get($code, true);
        }

        foreach ($this->productLine() as $product) {
            try {
                $product = $this->resolve($product);
            } catch (BindingResolutionException $e) {
                $this->throwProductNotFoundException($code);
            }

            if ($product instanceof Model) {
                $product = $product->where('code', $code)->first();
            }

            if (! is_null($product)) {
                $product->validate();

                return $product;
            }
        }

        $this->throwProductNotFoundException($code);
    }

    /**
     * Indicate to the developer that a valid product was not found.
     *
     * @param string $code
     *
     * @return void
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    protected function throwProductNotFoundException(string $code): void
    {
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
