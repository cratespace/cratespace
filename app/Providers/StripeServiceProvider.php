<?php

namespace App\Providers;

use Stripe\Stripe;
use App\Services\Stripe\Client;
use App\Services\Stripe\Logger;
use Stripe\Util\LoggerInterface;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLogger();

        Stripe::setAppInfo(
            'Cratespace',
            config('app.version'),
            'https://cratespace.biz'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();

        $this->bindLogger();
    }

    /**
     * Bind the Stripe logger interface to the Cashier logger.
     *
     * @return void
     */
    protected function bindLogger(): void
    {
        $this->app->bind(LoggerInterface::class, function ($app) {
            return new Logger(
                $app->make('log')->channel($this->getConfig('logger'))
            );
        });
    }

    /**
     * Register the Stripe logger.
     *
     * @return void
     */
    protected function registerLogger(): void
    {
        if ($this->getConfig('logger')) {
            Stripe::setLogger($this->app->make(LoggerInterface::class));
        }
    }

    /**
     * Get Stripe service configurations.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function getConfig(string $key)
    {
        return config("billing.services.stripe.{$key}");
    }

    /**
     * Register Stripe client.
     *
     * @return void
     */
    protected function registerClient(): void
    {
        $this->app->singleton('stripe.client', function ($app) {
            $client = new Client($app);

            $client->make();

            return $client;
        });
    }
}
