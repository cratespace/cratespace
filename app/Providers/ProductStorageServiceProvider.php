<?php

namespace App\Providers;

use App\Products\Finder;
use App\Products\Manifest;
use App\Actions\Product\FindProduct;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Actions\FindsProducts;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class ProductStorageServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The sentinel action classes.
     *
     * @var array
     */
    protected $actions = [
        FindsProducts::class => FindProduct::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManifest();

        $this->registerFinder();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerActions();
    }

    /**
     * Register product storage manifest.
     *
     * @return void
     */
    protected function registerManifest(): void
    {
        $this->app->singleton(Manifest::class);
    }

    /**
     * Register product finder.
     *
     * @return void
     */
    protected function registerFinder(): void
    {
        $this->app->singleton(Finder::class);
    }
}
