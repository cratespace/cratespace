<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\PaymentGateways\StripePaymentGateway;

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
        $this->app->bind(StripePaymentGateway::class, function ($app) {
            return new StripePaymentGateway($app['config']->get('services.stripe.secret'));
        });

        $this->app->bind(PaymentGateway::class, StripePaymentGateway::class);
    }
}
