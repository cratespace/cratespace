<?php

namespace App\Queries;

use App\Models\Order;
use App\Filters\OrderFilter;
use Cratespace\Preflight\Queries\Query;
use Illuminate\Database\Eloquent\Builder;

class OrderQuery extends Query
{
    /**
     * Instance of model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model = Order::class;

    /**
     * List all latest orders.
     *
     * @param \App\Filters\OrderFilter $request
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listing(OrderFilter $filter): Builder
    {
        return $this->model()->latest()->filter($filter);
    }
}
