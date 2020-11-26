<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setHttpSchema();
    }

    /**
     * Force application to use HTTPS.
     *
     * @return void
     */
    protected function setHttpSchema(): void
    {
        if ($this->app->isProduction()) {
            $this->app['url']->forceScheme('https');
        }
    }
}
