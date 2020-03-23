<?php

namespace App\Providers;

use App\Resources\Payments\Purchase;
use Illuminate\Support\ServiceProvider;
use App\Resources\Spaces\SpacesMaintainer;
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
        $this->registerPricingCalculator();
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
     * Register product pricing calculator
     */
    protected function registerPricingCalculator()
    {
        $this->app->bind('purchase', function () {
            $purchase = new Purchase();

            $purchase->taxRate();
            $purchase->serviceRate();

            return $purchase;
        });
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
