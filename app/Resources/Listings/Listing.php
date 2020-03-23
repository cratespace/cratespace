<?php

namespace App\Resources\Listings;

use App\Models\User;
use App\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

abstract class Listing
{
    /**
     * The resource model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * All available resources.
     *
     * @var \lluminate\Database\Eloquent\Collection
     */
    protected $listings;

    /**
     * Create a new space controller instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch all relevant resources as collection.
     *
     * @param \App\Filters\Filters|null $filters
     * @param \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    abstract public function get(Filter $filters, User $user = null);
}
