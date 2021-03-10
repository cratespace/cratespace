<?php

namespace App\Providers;

use Stripe\StripeClient;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton('stripe.client', function ($app) {
            return new StripeClient($app['config']->get('billing.key'));
        });
    }
}
