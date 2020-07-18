<?php

namespace App\Maintainers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

abstract class Maintainer
{
    /**
     * Get specified resource as query builder instance.
     *
     * @param string $key
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getResource(string $key): Builder
    {
        return DB::table($key);
    }
}
