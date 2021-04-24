<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Products\Factories\SpaceFactory;

class ProductFactoryServiceProvider extends ServiceProvider
{
    /**
     * List of all product factories.
     *
     * @var array
     */
    protected $factories = [
        SpaceFactory::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerFactories();
    }

    /**
     * Register all product factories.
     *
     * @return void
     */
    protected function registerFactories(): void
    {
        collect($this->factories)->each(function ($fatory) {
            $this->app->singleton($fatory);
        });
    }
}
