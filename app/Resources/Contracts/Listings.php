<?php

namespace App\Resources\Contracts;

use App\Models\User;
use App\Filters\Filter;

interface Listings
{
    /**
     * Get
     * @param  \App\Filters\Filter|null $filters
     * @param  \App\Models\User|null         $user
     * @return \Illuminate\Support\Collection
     */
    public function get(Filter $filters = null, User $user = null);
}
