<?php

namespace App\Contracts\Actions;

use App\Contracts\Billing\Product;

interface FindsProducts
{
    /**
     * Find the product with the given code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     */
    public function find(string $code): Product;
}
