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
     * Register default payment gateway.
     *
     * @return void
     */
    protected function registerPaymentGateways(): void
    {
        $this->app->bind(FakePaymentGateway::class, function ($app) {
            return new FakePaymentGateway();
        });

        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
    }
}
