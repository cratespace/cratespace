<?php

namespace App\Reports;

use Carbon\Carbon;

class DailyReport extends Report
{
    /**
     * Parse data into yearly report graph.
     *
     * @param  int|null $userId
     * @return array
     */
    public function make(?int $userId = null)
    {
        foreach ($this->groupByDay($userId) as $key => $value) {
            $this->count[(int) $key] = count($value);
        }

        $this->countPerDay();

        return collect($this->graphData);
    }

    /**
     * Group coleted data by month.
     *
     * @param  int|null $userId
     * @return \Illuminate\Support\Collection
     */
    protected function groupByDay(?int $userId = null)
    {
        return $this->collectDataOf($userId)->select('id', 'created_at')
            ->get()->groupBy(function ($model) {
                return Carbon::parse($model->created_at)->format('d');
            });
    }

    /**
     * Count entreis in a month.
     */
    protected function countPerDay()
    {
        for ($i = 1; $i <= date('t'); $i++) {
            if (isset($this->count[$i])) {
                $this->graphData[$i] = $this->count[$i];
            } else {
                $this->graphData[$i] = 0;
            }
        }
    }
}
