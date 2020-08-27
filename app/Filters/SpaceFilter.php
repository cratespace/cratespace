<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class SpaceFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'origin', 'destination', 'type', 'status',
        'departs_at', 'arrives_at',
    ];

    /**
     * Filter the query by a given origin destination.
     *
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function origin(string $city): Builder
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
    protected function destination(string $city): Builder
    {
        return $this->builder->whereDestination($city);
    }

    /**
     * Filter according to departure date and time.
     *
     * @param \Carbon\Carbon $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function departs_at(string $date): Builder
    {
        return $this->builder->whereDate('departs_at', 'like', Carbon::parse($date));
    }

    /**
     * Filter according to arrival date and time.
     *
     * @param \Carbon\Carbon $date
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function arrives_at(string $date): Builder
    {
        return $this->builder->whereDate('arrives_at', 'like', Carbon::parse($date));
    }

    /**
     * Filter spaces by type / locality.
     *
     * @param string $option
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type(string $option): Builder
    {
        if ($option == 'all') {
            return $this->builder;
        }

        return $this->builder->whereType($option);
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
        switch ($status) {
            case 'Available':
                return $this->builder->whereNull('reserved_at');

                break;

            case 'Ordered':
                return $this->builder
                    ->whereDate('departs_at', '>', Carbon::now())
                    ->whereNotNull('reserved_at');

                break;

            case 'Expired':
                return $this->builder
                    ->whereDate('departs_at', '<=', Carbon::now())
                    ->whereNull('reserved_at');

                break;
        }
    }
}
