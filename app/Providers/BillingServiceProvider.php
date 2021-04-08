<?php

namespace App\Providers;

use App\Models\Order;
use App\Orders\ConfirmationNumber;
use App\Actions\Product\MakePurchase;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Actions\MakesPurchases;
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

        $this->app->bind(ConfirmationNumber::class);
    }
}
