<?php

namespace App\Filters;

use Carbon\Carbon;
use Cratespace\Preflight\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'created_at',
    ];

    /**
     * Filter according to created date and time.
     *
     * @param \Carbon\Carbon $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function createdAt(Carbon $date): Builder
    {
        return $this->builder->whereDate('created_at', $date);
    }
}
