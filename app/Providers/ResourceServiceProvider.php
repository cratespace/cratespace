<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Space;
use App\Listings\OrderListing;
use App\Listings\SpaceListing;
use Illuminate\Support\Facades\DB;
use App\Maintainers\OrdersMaintainer;
use App\Maintainers\SpacesMaintainer;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * All listing classes.
     *
     * @var array
     */
    protected $listings = [
        Space::class => SpaceListing::class,
        Order::class => OrderListing::class,
    ];

    /**
     * Resource maintenance classes.
     *
     * @var array
     */
    protected $resourceMaintainers = [
        Space::class => SpacesMaintainer::class,
        Order::class => OrdersMaintainer::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->appReady()) {
            $this->runResourceMaintenance();
        }
    }

    /**
     * Boot up all listing objects with relevant dependencies.
     */
    protected function registerListings()
    {
        foreach ($this->listings as $model => $listing) {
            $this->app->bind(
                'listings.' . strtolower(class_basename($model)),
                function () use ($model, $listing) {
                    return new $listing(new $model());
                }
            );
        }
    }

    /**
     * Perform database resource maintenance.
     */
    protected function runResourceMaintenance()
    {
        foreach ($this->resourceMaintainers as $resource => $maintainer) {
            $this->app->makeWith($maintainer, ['model' => new $resource()]);
        }
    }

    /**
     * Determine if the app is ready to run.
     */
    public function appReady()
    {
        return ! $this->app->runningUnitTests() &&
            DB::connection()->getDatabaseName();
    }
}
