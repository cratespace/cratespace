<?php

namespace App\Providers;

use App\Billing\Charges\Calculator;
use Illuminate\Support\ServiceProvider;
use App\Billing\Actions\CalculateCharges;
use App\Contracts\Billing\PaymentGateway;
use App\Contracts\Billing\CalculatesCharges;
use App\Billing\PaymentGateways\StripePaymentGateway;
use App\Contracts\Support\Calculator as CalculatorContract;

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
        $this->registerChargeCalculator();
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

    /**
     * Register resource charge calculator.
     *
     * @return void
     */
    protected function registerChargeCalculator(): void
    {
        $this->app->singleton(CalculatorContract::class, Calculator::class);
        $this->app->singleton(CalculatesCharges::class, CalculateCharges::class);
    }
}
