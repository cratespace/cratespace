<?php

namespace App\Providers;

use App\Products\Finder;
use App\Products\Inventory;
use Illuminate\Support\Arr;
use App\Products\Line\Space;
use App\Contracts\Products\Product;
use App\Actions\Products\FindProduct;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Products\FindsProducts;
use App\Contracts\Products\Finder as FinderContract;
use Cratespace\Sentinel\Providers\Traits\HasActions;
use App\Contracts\Products\Inventory as InventoryContract;

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
        $this->registerInventory();

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

        $this->storeProducts();
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

    /**
     * Add a product or products to the product lineup.
     *
     * @param \App\Contracts\Products\Product|array $product
     *
     * @return void
     */
    public static function addToProductLine($product): void
    {
        static::$line = array_merge(static::$line, Arr::wrap($product));
    }

    /**
     * Register the product inventory manager.
     *
     * @return void
     */
    protected function registerInventory(): void
    {
        $this->app->singleton(InventoryContract::class, function ($app) {
            return new Inventory($app);
        });
    }

    /**
     * Place where products independant from the database can be stored inside the inventory.
     *
     * @return void
     */
    protected function storeProducts(): void
    {
    }
}
