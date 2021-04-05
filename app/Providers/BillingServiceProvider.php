<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Space;
use App\Contracts\Billing\Product;
use App\Actions\Customer\MakePurchase;
use Illuminate\Support\ServiceProvider;
use App\Actions\Product\CreateNewProduct;
use App\Contracts\Actions\MakesPurchases;
use App\Contracts\Actions\CreatesNewResources;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Contracts\Billing\Order as OrderContract;
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
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerOrderManager();

        $this->registerActions();
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

    /**
     * Register order manager.
     *
     * @return void
     */
    public function registerOrderManager(): void
    {
        $this->app->bind(OrderContract::class, Order::class);
    }
}
