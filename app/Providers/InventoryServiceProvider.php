<?php

namespace App\Providers;

use App\Products\Finder;
use App\Products\Line\Space;
use App\Actions\Products\FindProduct;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Products\FindsProducts;
use App\Contracts\Products\Finder as FinderContract;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class InventoryServiceProvider extends ServiceProvider
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
     * Cratespace product line.
     *
     * @var array
     */
    protected static $line = [
        Space::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProductFinder();
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
     * Register a product finder instance.
     *
     * @return void
     */
    protected function registerProductFinder(): void
    {
        $this->app->singleton(FinderContract::class, Finder::class);
    }

    /**
     * Get Cratespace's product line.
     *
     * @return array
     */
    public static function productLine(): array
    {
        return static::$line;
    }
}
