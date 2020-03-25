<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Space;
use App\Listings\OrderListing;
use App\Listings\SpaceListing;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerSpaceResources();
        $this->registerOrderResources();
    }

    /**
     * Register space resource listings.
     */
    protected function registerSpaceResources()
    {
        $this->app->bind('listings.space', function () {
            return new SpaceListing(new Space());
        });
    }

    /**
     * Register order resource listings.
     */
    protected function registerOrderResources()
    {
        $this->app->bind('listings.order', function () {
            return new OrderListing(new Order());
        });
    }
}
