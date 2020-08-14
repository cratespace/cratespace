<?php

namespace App\Queries;

use App\Models\Space;
use App\Filters\Filter;
use App\Models\Business;
use App\Facades\Location;
use Illuminate\Database\Eloquent\Builder;

class SpaceQuery extends Query
{
    /**
     * Instance of model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected static $model = Space::class;

    /**
     * Get all spaces associated with the currently authenticated business.
     *
     * @param \App\Filters\Filter $filters
     * @param string|null         $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function ofBusiness(Filter $filters, ?string $search = null): Builder
    {
        return static::model()->query()
            ->whereUserId(user('id'))
            ->filter($filters)
            ->latest('created_at');
    }

    /**
     * Get spaces that have departing date set for today.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function departing(): Builder
    {
        return static::model()->query()
            ->whereBetween('departs_at', [
                now(), now()->endOfDay(),
            ])
            ->latest('departs_at');
    }

    /**
     * Scope a query to only include spaces based in user's country.
     *
     * @param \App\Filters\Filter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function list(Filter $filters): Builder
    {
        return static::model()->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->where('base', Location::getCountry() ?: config('location.fallback.country'))
            ->whereDate('departs_at', '>', now())
            ->whereNull('reserved_at')
            ->filter($filters)
            ->latest('departs_at');
    }
}
