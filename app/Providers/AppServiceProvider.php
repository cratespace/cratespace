<?php

namespace App\Providers;

use NumberFormatter;
use Illuminate\Pagination\Paginator;
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
        $this->registerCurrencyFormat();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
    }

    /**
     * Set default current format.
     */
    protected function registerCurrencyFormat()
    {
        $this->app->singleton('currency-formatter', function () {
            return new NumberFormatter(
                config('cashier.currency'),
                NumberFormatter::CURRENCY
            );
        });
    }
}
