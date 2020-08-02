<?php

namespace App\Providers;

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
        $this->registerMarkdownParser();
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
     * Register markdown parser.
     */
    public function registerMarkdownParser(): void
    {
        $this->app->singleton(Parsedown::class, function () {
            $parsedown = new \Parsedown();

            $parsedown->setSafeMode(true);

            return $parsedown;
        });
    }
}
