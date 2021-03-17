<?php

namespace App\Providers;

use Stripe\StripeClient;
use App\Billing\Stripe\Client;
use Stripe\StripeClientInterface;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Billing\Client as ClientContract;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();
    }

    /**
     * Register Stripe client.
     *
     * @return void
     */
    protected function registerClient(): void
    {
        $this->app->singleton(StripeClientInterface::class, function ($app) {
            return new StripeClient($app['config']->get('billing.secret'));
        });

        $this->app->singleton(ClientContract::class, Client::class);
    }
}
