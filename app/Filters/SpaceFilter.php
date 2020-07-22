<?php

namespace App\Filters;

class SpaceFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'origin', 'destination', 'type', 'departs_at', 'arrives_at',
    ];

    /**
     * Filter the query by a given origin destination.
     *
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function origin($city)
    {
        return $this->builder->whereOrigin($city);
    }

    /**
     * Filter the query by a given arrival destination.
     *
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function destination($city)
    {
        return $this->builder->whereDestination($city);
    }

    /**
     * Filter according to departure date and time.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function departs_at($date)
    {
        return $this->builder->whereDate('departs_at', '=', $date);
    }

    /**
     * Filter according to arrival date and time.
     *
     * @param string $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function arrives_at($date)
    {
        return $this->builder->whereDate('arrives_at', '=', $date);
    }

    /**
     * Filter spaces by type / locality.
     *
     * @param string $locality
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($option)
    {
        if ($option == 'all') {
            return $this->builder;
        }

        return $this->builder->whereType($option);
    }
}
