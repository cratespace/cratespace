<?php

namespace App\Contracts\Products;

interface Finder
{
    /**
     * Find a product using the given product code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products
     */
    public function find(string $code): Product;
}
