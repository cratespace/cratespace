<?php

namespace App\Providers;

use App\Actions\Customer\MakePurchase;
use Illuminate\Support\ServiceProvider;
use App\Actions\Product\CreateNewProduct;
use App\Contracts\Actions\MakesPurchases;
use App\Contracts\Actions\CreatesNewResources;
use App\Billing\PaymentGateways\PaymentGateway;
use Cratespace\Sentinel\Providers\Traits\HasActions;
use App\Billing\PaymentGateways\StripePaymentGateway;

class BillingServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The sentinel action classes.
     *
     * @var array
     */
    protected $actions = [
        MakesPurchases::class => MakePurchase::class,
        CreatesNewResources::class => CreateNewProduct::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPaymentGateway();

        $this->registerActions();
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
     * Register payment gateway instance.
     *
     * @return void
     */
    public function registerPaymentGateway(): void
    {
        $this->app->singleton(PaymentGateway::class, StripePaymentGateway::class);
    }
}
