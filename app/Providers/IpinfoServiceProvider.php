<?php

namespace App\Providers;

use App\Services\Ipinfo\Client;
use Illuminate\Support\ServiceProvider;

class IpinfoServiceProvider extends ServiceProvider
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
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register Ipinfo client.
     *
     * @return void
     */
    protected function registerClient(): void
    {
        $this->app->singleton('ipinfo.client', function ($app) {
            $client = new Client($app['request']);

            $client->make([
                'access_token' => $app['config']->get(
                    'services.ipinfo.access_token'
                ),
            ]);

            return $client;
        });
    }
}
