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
        $fakePaymentGateway = new FakePaymentGateway();

        $this->app->instance(PaymentGateway::class, $fakePaymentGateway);
    }
}
