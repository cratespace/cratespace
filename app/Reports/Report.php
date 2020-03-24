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
     * Model data.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $data;

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
     * @param  \Illuminate\Support\Collection $data
     * @return array
     */
    abstract public function make();

    /**
     * Collect model data of given user for graphing.
     *
     * @param  int $userId
     * @return \Illuminate\Support\Collection
     */
    public function collectDataOf($userId = null)
    {
        $this->data = $this->model->whereUserId($userId ?? user('id'))
            ->select('id', 'created_at')
            ->get()->groupBy(function ($model) {
                return Carbon::parse($model->created_at)->format('m');
            });
    }

    /**
     * Get model data.
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Get data count per month.
     *
     * @return array
     */
    public function count()
    {
        return $this->count;
    }
}
