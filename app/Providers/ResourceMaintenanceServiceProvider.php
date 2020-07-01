<?php

namespace App\Providers;

use App\Providers\Traits\AppStatus;
use App\Maintainers\OrdersMaintainer;
use App\Maintainers\SpacesMaintainer;
use Illuminate\Support\ServiceProvider;
use App\Maintainers\OrderSpaceMaintainer;

class ResourceMaintenanceServiceProvider extends ServiceProvider
{
    use AppStatus;

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
        if ($this->hasDatabaseConnection()) {
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
}
