<?php

namespace App\Models\Queries;

use App\Models\Space;

class SpaceQueries extends Space
{
    /**
     * Get all spaces associated with the currently authenticated business.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param \App\Filters\Filter                $filters
     * @param string|null                        $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfBusiness($query, Filter $filters, ?string $search = null)
    {
        $query->addSelect([
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
}
