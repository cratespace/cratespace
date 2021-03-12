<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class BillingServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The billing/purchase action classes.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPaymentGateway();
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

    protected function registerPaymentGateway()
    {
    }
}
