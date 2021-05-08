<?php

namespace App\Contracts\Products;

interface Inventory
{
    /**
     * Store a product inside the inventory.
     *
     * @param \App\Contracts\Products\Product|string $product
     * @param array|null                             $parameters
     *
     * @return mixed
     */
    public function store($product, ?array $parameters = null);

    /**
     * Get a product out of the inventory.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products\Product|null
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function get(string $code, bool $queitly = false): ?Product;
}
