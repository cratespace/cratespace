<?php

namespace App\Providers\Traits;

use PDO;
use Exception;
use Illuminate\Support\Facades\DB;

trait AppStatus
{
    /**
     * Determine if the app environment is set to testing.
     */
    public function isRunningUnitTests()
    {
        return $this->app->runningUnitTests();
    }

    /**
     * Determine if database connection is available.
     *
     * @return bool
     */
    protected function hasDatabaseConnection()
    {
        try {
            return DB::connection()->getPdo() instanceof PDO;
        } catch (Exception $th) {
            return false;
        }
    }
}
