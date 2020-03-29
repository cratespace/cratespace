<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Space;
use App\Maintainers\OrdersMaintainer;
use App\Maintainers\SpacesMaintainer;
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
    }
}
