<?php

namespace App\Products;

use App\Contracts\Billing\Product;
use Illuminate\Contracts\Foundation\Application;

class Finder
{
    /**
     * The Cratespace application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create new instance of product finder.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function find(string $code): Product
    {
        $productClass = $this->makeValidClassName(
            $this->identifyCode($code)
        );

        return $this->app
            ->make($productClass)
            ->where('code', $code)
            ->firstOrFail();
    }
}
