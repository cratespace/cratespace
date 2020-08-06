<?php

namespace App\Models\Queries;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Space;
use App\Filters\Filter;
use App\Models\Business;
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
    public static function OfBusiness(Filter $filters, ?string $search = null): Builder
    {
        return static::model()->query()
            ->addSelect([
                'order_id' => Order::select('uid')
                    ->whereColumn('space_id', 'spaces.id')
                    ->latest()
                    ->take(1),
            ])
            ->whereUserId(user('id'))
            ->filter($filters)
            ->search($search)
            ->latest('created_at');
    }

    /**
     * Get spaces that have departing date set for today.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function Departing(): Builder
    {
        return static::model()->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->whereBetween('departs_at', [Carbon::now(), Carbon::now()->endOfDay()])
            ->latest('departs_at');
    }

    /**
     * Scope a query to only include spaces based in user's country.
     *
     * @param \App\Filters\Filter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function List(Filter $filters): Builder
    {
        return static::model()->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->whereDate('departs_at', '>', Carbon::now())
            ->doesntHave('order')
            ->filter($filters)
            ->latest('departs_at');
    }
}
