<?php

namespace App\Filters;

use App\Models\Business;
use Stevebauman\Location\Facades\Location;

class SpaceFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = [
        'business', 'origin', 'destination', 'type',
        'departs_at', 'arrives_at', 'status'
    ];

    /**
     * Filter the query by a given business name.
     *
     * @param  string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function business($slug)
    {
        $business = Business::whereSlug($slug)->firstOrFail();

        return $this->builder->where('user_id', $business->id);
    }

    /**
     * Filter the query by a given origin destination.
     *
     * @param  string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function origin($city)
    {
        return $this->builder->whereOrigin($city);
    }

    /**
     * Filter the query by a given arrival destination.
     *
     * @param  string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function destination($city)
    {
        return $this->builder->whereDestination($city);
    }

    /**
     * Filter according to departure date and time.
     *
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function departs_at($date)
    {
        return $this->builder->whereDate('departs_at', '=', $date);
    }

    /**
     * Filter according to arrival date and time.
     *
     * @param  string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function arrives_at($date)
    {
        return $this->builder->whereDate('arrives_at', '=', $date);
    }

    /**
     * Filter spaces by status.
     *
     * @param  string $locality
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($status)
    {
        return $this->builder->whereStatus($status);
    }

    /**
     * Filter spaces by type / locality.
     *
     * @param  string $locality
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($option)
    {
        if ($option === 'Local') {
            return $this->builder->whereType('Local');
        }

        return $this->builder->whereType('International');
    }
}
