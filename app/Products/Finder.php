<?php

namespace App\Products;

use App\Support\Util;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
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
     */
    public function find(string $code): Product
    {
        try {
            $product = $this->manifest->match($code);
        } catch (ProductNotFoundException $e) {
            $product = $this->resolve($this->identifyUsingCode($code));
        }

        return $product;
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

        if (is_string($class)) {
            $class = app($class);
        }

        if ($class instanceof Model) {
            return $class::findOrFail($id);
        }

        return new $class($id);
    }

    /**
     * Parse the product code to identify product class and ID.
     *
     * @param string $code
     *
     * @return array
     */
    public function identifyUsingCode(string $code): array
    {
        try {
            [$class, $id] = explode('-', Crypt::decryptString($code));
        } catch (DecryptException $e) {
            throw new InvalidProductException("Product with code [{$code}] does not exist");
        }

        return [Util::className($class), $id];
    }
}
