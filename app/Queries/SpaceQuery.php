<?php

namespace App\Queries;

use App\Models\Business;
use App\Filters\SpaceFilter;
use App\Products\Line\Space;
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
     * The space listing query.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listing(SpaceFilter $filters): Builder
    {
        return $this->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->first(),
            ])
            ->whereDate('departs_at', '>', now())
            ->whereNull('reserved_at')
            ->filter($filters)
            ->latest('departs_at');
    }

    /**
     * The space listing query.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function business(SpaceFilter $filters): Builder
    {
        return $this->query()->filter($filters);
    }
}
