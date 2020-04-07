<?php

namespace App\Providers;

use App\Maintainers\OrdersMaintainer;
use App\Maintainers\OrderSpaceMaintainer;
use App\Maintainers\SpacesMaintainer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
        return !$this->app->runningUnitTests() &&
            DB::connection()->getDatabaseName();
    }
}
