<?php

namespace App\Providers;

use App\Orders\Order;
use App\Orders\ConfirmationNumber;
use Illuminate\Support\ServiceProvider;
use App\Actions\Products\PurchaseProduct;
use App\Contracts\Billing\MakesPurchases;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Contracts\Orders\Order as OrderContract;
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
        MakesPurchases::class => PurchaseProduct::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPaymentGateway();

        $this->registerOrderManagement();
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

    /**
     * Register default payment gateway.
     *
     * @return void
     */
    protected function registerPaymentGateway(): void
    {
        $this->app->singleton(PaymentGateway::class, StripePaymentGateway::class);
    }

    /**
     * Register default payment gateway.
     *
     * @return void
     */
    protected function registerOrderManagement(): void
    {
        $this->app->singleton(OrderContract::class, Order::class);

        $this->app->singleton(ConfirmationNumber::class);
    }
}
