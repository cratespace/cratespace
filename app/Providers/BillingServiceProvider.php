<?php

namespace App\Providers;

use App\Billing\Payments\FakeGateway;
use App\Actions\Billing\PurchaseSpace;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Actions\Billing\MakesPurchase;
use App\Billing\Payments\Gateway as PaymentGateway;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class BillingServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The billing/purchase action classes.
     *
     * @var array
     */
    protected $actions = [
        MakesPurchase::class => PurchaseSpace::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPaymentGateway();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerActions();
    }

    protected function registerPaymentGateway()
    {
        $this->app->singleton(
            PaymentGateway::class,
            $this->app->runningUnitTests() ? FakeGateway::class : null
        );
    }
}
