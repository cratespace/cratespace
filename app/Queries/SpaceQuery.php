<?php

namespace App\Queries;

use App\Models\Space;
use App\Models\Business;
use App\Filters\SpaceFilter;
use Cratespace\Preflight\Queries\Query;
use Illuminate\Database\Eloquent\Builder;

class SpaceQuery extends Query
{
    /**
     * Create new SpaceQuery instance.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function __construct(Space $space)
    {
        parent::__construct($space);
    }

    /**
     * The space listing query.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listing(SpaceFilter $filters): Builder
    {
        return $this->model
            ->query()
            ->addSelect([
                'business' => Business::select('name')
                    ->whereColumn('user_id', 'spaces.user_id')
                    ->latest()
                    ->take(1),
            ])
            ->whereDate('departs_at', '>', now())
            ->whereNull('reserved_at')
            ->filter($filters)
            ->latest('departs_at');
    }
}
