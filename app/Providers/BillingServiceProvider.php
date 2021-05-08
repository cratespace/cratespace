<?php

namespace App\Providers;

use App\Orders\Order;
use App\Orders\ConfirmationNumber;
use Illuminate\Support\ServiceProvider;
use App\Billing\Gateways\PaymentGateway;
use App\Actions\Products\PurchaseProduct;
use App\Contracts\Billing\MakesPurchases;
use App\Contracts\Orders\Order as OrderContract;
use Cratespace\Sentinel\Providers\Traits\HasActions;

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
        $this->app->singleton(PaymentGateway::class, function () {
            return $this->createDefaultPaymentService();
        });
    }

    /**
     * Create the default billing service.
     *
     * @return \App\Billing\Gateways\PaymentGateway
     */
    protected function createDefaultPaymentService(): PaymentGateway
    {
        $service = config('billing.defaults.service');

        return $this->app->make(
            config("billing.services.{$service}.gateway")
        );
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
