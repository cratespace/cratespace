<?php

namespace App\Products;

use App\Support\Util;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Crypt;

class Finder
{
    /**
     * The products module manifest.
     *
     * @var \App\Products\Manifest
     */
    protected $manifest;

    /**
     * Create new instance of product finder.
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
     * Find the appropriate product from the given code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Billing\Product
     */
    public function find(string $code): Product
    {
        [$model, $id] = $this->identifyCode($code);

        return $model::findOrFail($id);
    }

    /**
     * Decrypt and validate product class name.
     *
     * @param string $code
     *
     * @return array
     */
    public function identifyCode(string $code): array
    {
        [$class, $id] = explode('-', Crypt::decryptString($code));

        $this->manifest->validateProductClass($class);

        return [Util::className($class), $id];
    }
}
