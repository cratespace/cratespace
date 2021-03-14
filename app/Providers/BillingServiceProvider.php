<?php

namespace App\Providers;

use App\Billing\Gateways\Gateway;
use App\Billing\Gateways\StripeGateway;
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

    /**
     * Register payment gateways to the application.
     *
     * @return void
     */
    protected function registerPaymentGateway(): void
    {
        $this->app->singleton(Gateway::class, StripeGateway::class);
    }
}
