<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\FakePaymentGateway;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPaymentGateways();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register default payment gateway.
     *
     * @return void
     */
    protected function registerPaymentGateways(): void
    {
        $this->app->instance(PaymentGateway::class, new FakePaymentGateway());
    }
}
