<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class Report
{
    /**
     * The model to be reported on.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Data count per month.
     *
     * @var array
     */
    protected $count = [];

    /**
     * Create new report instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Parse data into yearly report graph.
     *
     * @param  int|null $userId
     * @return array
     */
    abstract public function make();

    /**
     * Collect model data of given user for graphing.
     *
     * @param  int $userId|null
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function collectDataOf(?int $userId = null)
    {
        return $this->model->whereUserId($userId ?? user('id'));
    }
}
