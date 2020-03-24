<?php

namespace App\Providers;

use App\Maintainers\SpacesMaintainer;
use Illuminate\Support\ServiceProvider;
use App\Providers\Traits\DatabaseConnecionCheck;

class AppServiceProvider extends ServiceProvider
{
    use DatabaseConnecionCheck;

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
        if ($this->checkDatabaseConnection()) {
            $this->checkDepartedSpaces();
        }
    }

    /**
     * Determine and mark expired shippments.
     */
    public function checkDepartedSpaces()
    {
        if (! $this->app->runningUnitTests()) {
            (new SpacesMaintainer())->run();
        }
    }
}
