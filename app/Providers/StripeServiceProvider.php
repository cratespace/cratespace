<?php

namespace App\Providers;

use App\Services\Stripe\Client;
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
        $this->app->singleton(Client::class, function () {
            return Client::make();
        });
    }
}
