<?php

namespace App\Providers;

use App\Products\Finder;
use App\Products\Manifest;
use Illuminate\Support\ServiceProvider;

class ProductStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManifest();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerFinder();
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
        $this->app->singleton(
            Finder::class,
            fn ($app) => new Finder($app->make(Manifest::class))
        );
    }
}
