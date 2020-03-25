<?php

namespace App\Filters;

use App\Models\Business;
use Stevebauman\Location\Facades\Location;

class OrderFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'createdAt', 'status'
    ];

    /**
     * Filter according to placed date and time.
     *
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function createdAt($date)
    {
        return $this->builder->whereDate('arrives_at', '=', $date);
    }

    /**
     * Filter orders by status.
     *
     * @param  string $locality
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($status)
    {
        return $this->builder->whereStatus($status);
    }
}
