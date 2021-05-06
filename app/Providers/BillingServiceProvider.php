<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Actions\Products\PurchaseProduct;
use App\Contracts\Billing\MakesPurchases;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class BillingServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The sentinel action classes.
     *
     * @var array
     */
    protected $actions = [
        MakesPurchases::class => PurchaseProduct::class,
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
        $this->registerActions();
    }
}
