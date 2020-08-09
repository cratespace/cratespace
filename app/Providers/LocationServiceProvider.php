<?php

namespace App\Providers;

use App\Http\Services\IpService;
use App\Http\Services\LocationService;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerIpService();
        $this->registerLocationService();
    }

    /**
     * Register IP address retrieval service.
     *
     * @return void
     */
    protected function registerIpService(): void
    {
        $this->app->singleton('ip', function ($app) {
            return new IpService($app['request']);
        });
    }

    /**
     * Register location retrieval service.
     *
     * @return void
     */
    protected function registerLocationService(): void
    {
        $this->app->singleton('location', function ($app) {
            return new LocationService($app['request'], $app['ip']);
        });
    }
}
