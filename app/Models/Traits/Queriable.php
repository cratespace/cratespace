<?php

namespace App\Models\Traits;

use Cratespace\Preflight\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait Queriable
{
    /**
     * Undocumented function.
     *
     * @param \Cratespace\Preflight\Filters\Filter $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function makeQuery(string $condition, Filter $filter): Builder
    {
        return static::getQueriable($condition)->filter($filter)->latest();
    }

    /**
     * Get the instance of the query class for this resource.
     *
     * @param string $condition
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function getQueriable(string $condition): Builder
    {
        $class = class_basename(static::class);

        $instance = resolve("App\\Queries\\{$class}Query");

        return $instance->{$condition}();
    }
}
