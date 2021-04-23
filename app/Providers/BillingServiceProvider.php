<?php

namespace App\Providers;

use App\Models\Order;
use App\Orders\ConfirmationNumber;
use Illuminate\Support\ServiceProvider;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Contracts\Billing\Order as OrderContract;
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
        $this->registerPaymentGateway();

        $this->registerOrderManager();
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
     * Register payment gateway instance.
     *
     * @return void
     */
    public function registerPaymentGateway(): void
    {
        $this->app->singleton(PaymentGateway::class, StripePaymentGateway::class);
    }

    /**
     * Register order manager.
     *
     * @return void
     */
    public function registerOrderManager(): void
    {
        $this->app->bind(OrderContract::class, Order::class);

        $this->app->bind(ConfirmationNumber::class);
    }
}
