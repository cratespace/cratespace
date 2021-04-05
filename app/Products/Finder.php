<?php

namespace App\Products;

use ReflectionClass;
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
     *
     * @throws \App\Exceptions\ProductNotFoundException
     */
    public function find(string $code): Product
    {
        try {
            $product = $this->manifest->match($code);
        } catch (ProductNotFoundException $e) {
            $product = $this->identifyUsingCode($code);
        }

        if (! $product instanceof Product) {
            $this->throwInvalidProductException($code);
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
        try {
            [$class, $id] = explode('-', Crypt::decryptString($code));
        } catch (DecryptException $e) {
            $this->throwInvalidProductException($code);
        }

        return $this->resolve($class, $id);
    }

    /**
     * Resolve the product instance.
     *
     * @param string   $class
     * @param int|null $id
     *
     * @return \App\Contracts\Billing\Product
     */
    protected function resolve(string $class, ?int $id = null): Product
    {
        return $this->isModel($class, $id) ? $class::find($id) : new $class($id);
    }

    /**
     * Determine if the given class is a model.
     *
     * @param string   $class
     * @param int|null $id
     *
     * @return bool
     */
    protected function isModel(string $class, ?int $id = null): bool
    {
        return (new ReflectionClass($class))->isSubclassOf(Model::class) && ! is_null($id);
    }

    /**
     * Throw exception because product with given code does not exist.
     *
     * @param string $code
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidProductException
     */
    protected function throwInvalidProductException(string $code): void
    {
        throw new InvalidProductException("Product with code [{$code}] does not exist");
    }
}
