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
     * Determine if the given product or code is stored in the inventory.
     *
     * @param \App\Contracts\Products\Product|string $product
     *
     * @return bool
     */
    public function has($product): bool;

    /**
     * Get a product out of the inventory.
     *
     * @param string $code
     * @param bool   $queitly
     *
     * @return \App\Contracts\Products\Product|null
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function get(string $code, bool $queitly = false): ?Product;
}
