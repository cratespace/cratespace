<?php

namespace App\Products;

use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\InvalidProductException;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Contracts\Encryption\DecryptException;

class Finder
{
    /**
     * The product storage manifest instance.
     *
     * @var \App\Products\Manifest
     */
    protected $manifest;

    /**
     * Create new product finder instance.
     *
     * @param \App\Products\Manifest $manifest
     *
     * @return void
     */
    public function __construct(Manifest $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * Find a product using the given product code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function find(string $code): Product
    {
        try {
            $product = $this->manifest->match($code);
        } catch (ProductNotFoundException $e) {
            try {
                $product = $this->identifyUsingCode($code);
            } catch (DecryptException $e) {
                $product = $e;
            }
        }

        if (! $product instanceof Product) {
            throw new InvalidProductException("Product with code [{$code}] does not exist");
        }

        return $product;
    }

    /**
     * Parse the product code to identify product class and ID.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     *
     * @throws \Illuminate\Contracts\Encryption\DecryptException
     */
    public function identifyUsingCode(string $code): Product
    {
        return $this->resolve(explode('-', Crypt::decryptString($code)));
    }

    /**
     * Resolve the product instance.
     *
     * @param array $details
     *
     * @return \App\Contracts\Billing\Product
     */
    protected function resolve(array $details): Product
    {
        [$class, $id] = $details;

        return $class::find($id) ?? new $class($id);
    }
}
