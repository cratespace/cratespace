<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Space;
use App\Listings\OrderListing;
use App\Listings\SpaceListing;
use App\Analytics\OrdersAnalyzer;
use App\Analytics\SpacesAnalyzer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        'spaces' => SpacesMaintainer::class,
        'orders' => OrdersMaintainer::class,
        'orders' => OrderSpaceMaintainer::class,
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
        foreach ($this->resourceMaintainers as $resourceKey => $maintainer) {
            (new $maintainer($resourceKey))->run();
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
