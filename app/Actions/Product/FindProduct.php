<?php

namespace App\Actions\Product;

use App\Products\Finder;
use App\Contracts\Billing\Product;

class FindProduct
{
    /**
     * The product finder instance.
     *
     * @var \App\Products\Finder
     */
    protected $finder;

    /**
     * Create new instance of product finder action class.
     *
     * @param \App\Products\Finder $finder
     *
     * @return void
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Find the product with the given code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     */
    public function find(string $code): Product
    {
        return $this->finder->find($code);
    }
}
