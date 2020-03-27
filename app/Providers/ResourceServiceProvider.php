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
use App\Maintainers\OrderSpaceMaintainer;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Resource maintenance classes.
     *
     * @var array
     */
    protected $resourceMaintainers = [
        Space::class => SpacesMaintainer::class,
        Order::class => OrdersMaintainer::class,
        Order::class => OrderSpaceMaintainer::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
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
     * Perform database resource maintenance.
     */
    protected function runResourceMaintenance()
    {
        foreach ($this->resourceMaintainers as $resource => $maintainer) {
            $this->app->makeWith($maintainer, ['model' => new $resource()])->run();
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
