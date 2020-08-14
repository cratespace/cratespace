<?php

namespace App\Models\Traits;

use App\Filters\Filter;

trait Filterable
{
    /**
     * Apply all relevant space filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\Filter                   $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, Filter $filters)
    {
        return $filters->apply($query);
    }
}
