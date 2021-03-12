<?php

namespace App\Providers;

use App\Actions\Orders\PlaceOrder;
use App\Contracts\Actions\PlacesOrders;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Actions\MakesPurchase;
use Cratespace\Sentinel\Providers\Traits\HasActions;

class PurchaseServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The sentinel action classes.
     *
     * @var array
     */
    protected $actions = [
        MakesPurchase::class => PurchaseSpace::class,
        PlacesOrders::class => PlaceOrder::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerActions();
    }
}
