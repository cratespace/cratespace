<?php

namespace App\Console;

use App\Console\Commands\InstallCommand;
use App\Console\Commands\QueryMakeCommand;
use App\Console\Commands\ActionMakeCommand;
use App\Console\Commands\FilterMakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\RequestMakeCommand;
use App\Console\Commands\ResponseMakeCommand;
use App\Console\Commands\PresenterMakeCommand;
use App\Console\Commands\PublishConfigJsCommand;
use App\Console\Commands\SeedDefaultUserCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        ActionMakeCommand::class,
        FilterMakeCommand::class,
        PresenterMakeCommand::class,
        QueryMakeCommand::class,
        RequestMakeCommand::class,
        ResponseMakeCommand::class,
        PublishConfigJsCommand::class,
        SeedDefaultUserCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
