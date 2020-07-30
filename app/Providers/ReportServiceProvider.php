<?php

namespace App\Providers;

use App\Reports\Generator;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerReportGenerator();
    }

    /**
     * Register report generator.
     */
    protected function registerReportGenerator(): void
    {
    }
}
