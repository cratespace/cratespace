<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'status', 'created_at',
    ];

    /**
     * Filter according to created date and time.
     *
     * @param \Carbon\Carbon $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function created_at(Carbon $date): Builder
    {
        return $this->builder->whereDate('created_at', 'like', $date . '%');
    }

    /**
     * Filter spaces according to it's availability.
     *
     * @param string $status
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status(string $status): Builder
    {
        return $this->builder->whereStatus($status);
    }
}
