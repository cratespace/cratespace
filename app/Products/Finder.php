<?php

namespace App\Products;

use App\Contracts\Products\Product;
use Illuminate\Database\Eloquent\Model;
use App\Providers\InventoryServiceProvider;
use Illuminate\Collections\ItemNotFoundException;
use App\Contracts\Products\Finder as FinderContract;
use Cratespace\Sentinel\Support\Concerns\InteractsWithContainer;

class Finder implements FinderContract
{
    use InteractsWithContainer;

    /**
     * Find a product using the given product code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products
     */
    public function find(string $code): Product
    {
        foreach ($this->productLine() as $product) {
            $product = $this->resolve($product);

            $product = $product instanceof Model
                ? $product->where('code', $code)->first()
                : $product->match($code);

            if (! is_null($product)) {
                return $product;
            }
        }

        throw new ItemNotFoundException("Product with code [{$code}] not found");
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
