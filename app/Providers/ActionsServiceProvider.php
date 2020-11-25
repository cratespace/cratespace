<?php

namespace App\Providers;

use App\Actions\CreateNewOrder;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Actions\CreatesNewOrders;

class ActionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPurchaseOrderActions();
    }

    /**
     * Register all actions related to purchasing and order placement.
     *
     * @return void
     */
    protected function registerPurchaseOrderActions(): void
    {
        $this->app->singleton(CreatesNewOrders::class, CreateNewOrder::class);
    }
}
