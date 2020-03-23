<?php

namespace App\Providers\Traits;

use Illuminate\Support\Facades\DB;

trait DatabaseConnecionCheck
{
    /**
     * Determine if the app is connected to the database.
     *
     * @return bool
     */
    protected function checkDatabaseConnection()
    {
        return DB::connection()->getDatabaseName();
    }
}
