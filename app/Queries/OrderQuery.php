<?php

namespace App\Queries;

use App\Orders\Order;
use App\Filters\OrderFilter;
use Cratespace\Preflight\Queries\Query;
use Illuminate\Database\Eloquent\Model;
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
     * The space listing query.
     *
     * @param \App\Filters\OrderFilter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function business(OrderFilter $filters): Builder
    {
        return $this->query()->filter($filters);
    }
}
