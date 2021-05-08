<?php

namespace App\Actions\Products;

use App\Contracts\Products\Finder;
use App\Contracts\Products\Product;
use App\Contracts\Products\FindsProducts;

class FindProduct implements FindsProducts
{
    /**
     * The product finder instance.
     *
     * @var \App\Contracts\Products\Finder
     */
    protected $finder;

    /**
     * Create new FindProduct action class instance.
     *
     * @param \App\Contracts\Products\Finder $finder
     *
     * @return void
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
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
        return $this->finder->find($code);
    }
}
