<?php

namespace App\Listings;

use App\Models\User;
use App\Filters\Filter;
use App\Http\Services\Ip\Retriever;

class OrderListing extends Listing
{
    /**
     * Fetch all relevant resources as collection.
     *
     * @param \App\Filters\Filters $filters
     * @param \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(Filter $filters, ?User $user = null)
    {
        return $this->model->whereUserId($user->id ?? user('id'))
            ->with('space')
            ->latest()
            ->filter($filters)
            ->paginate(request('perpage') ?? 10);
    }
}
