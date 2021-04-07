<?php

namespace App\Filters;

use Cratespace\Preflight\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SpaceFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'departs_at',
        'arrives_at',
        'origin',
        'destination',
    ];

    /**
     * Filter the query by a given attribute value.
     *
     * @param mixed $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function departsAt($date): Builder
    {
        return $this->builder->whereDate('departs_at', $date);
    }

    /**
     * Filter the query by a given attribute value.
     *
     * @param mixed $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function arrivesAt($date): Builder
    {
        return $this->builder->whereDate('arrives_at', $date);
    }

    /**
     * Filter the query by a given attribute value.
     *
     * @param string $place
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function origin(string $place): Builder
    {
        return $this->builder->where('origin', $place);
    }

    /**
     * Filter the query by a given attribute value.
     *
     * @param string $place
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function destination(string $place): Builder
    {
        return $this->builder->where('destination', $place);
    }
}
