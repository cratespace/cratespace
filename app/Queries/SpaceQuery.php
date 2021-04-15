<?php

namespace App\Queries;

use App\Facades\Ip;
use App\Models\Space;
use App\Models\Business;
use App\Filters\SpaceFilter;
use Illuminate\Support\Facades\DB;
use Cratespace\Preflight\Queries\Query;
use Illuminate\Database\Eloquent\Builder;

class SpaceQuery extends Query
{
    /**
     * Instance of model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model = Space::class;

    /**
     * Get a listing of all available spaces.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listing(SpaceFilter $filters): Builder
    {
        return $this->model()
            ->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereColumn('orders.orderable_id', 'spaces.id');
            })
            ->when(! is_null($country = Ip::countryName()), function ($query) use ($country) {
                $query->whereBase($country);
            })
            ->whereNull('reserved_at')
            ->whereDate('departs_at', '>', now())
            ->filter($filters)
            ->latest('departs_at');
    }
}
