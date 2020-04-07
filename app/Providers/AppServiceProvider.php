<?php

namespace App\Providers;

use Carbon\Carbon;
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
        $this->registerMArkdowParser();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setWeekStartsAt(Carbon::MONDAY);
    }

    /**
     * Register markdown parser.
     */
    protected function registerMArkdowParser()
    {
        $this->app->bind('markdown.parser', function () {
            return new \Parsedown();
        });
    }
}
