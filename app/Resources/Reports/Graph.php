<?php

namespace App\Resources\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Resources\Contracts\Graphable;
use Illuminate\Database\Eloquent\Model;

class Graph implements Graphable
{
    /**
     * Model data.
     *
     * @var \Illuminate\Support\Collection
     */
    protected static $data;

    /**
     * Data count per month.
     *
     * @var array[]
     */
    protected static $count = [];

    /**
     * Data count per month with month number as key.
     *
     * @var array[]
     */
    protected static $graphData = [];

    /**
     * Parse data into yearly report graph.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return array
     */
    public function make()
    {
        foreach (static::$data as $key => $value) {
            static::$count[(int) $key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            static::$graphData[$i] = static::$count[$i] !== null ? static::$count[$i] : 0;
        }

        return collect(static::$graphData);
    }

    /**
     * Collect data of given model for graphing.
     *
     * @param  int $userId
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Support\Collection
     */
    protected function collectDataOf(Model $model, $userId)
    {
        $this->data = $model->whereUserId($userId ?? user('id'))
            ->select('id', 'created_at')
            ->get()->groupBy(function ($model) {
                return Carbon::parse($model->created_at)->format('m');
            });

        return self;
    }
}
