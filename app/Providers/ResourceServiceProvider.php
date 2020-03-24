<?php

namespace App\Providers;

use App\Models\Space;
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
}
