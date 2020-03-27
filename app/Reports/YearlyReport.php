<?php

namespace App\Reports;

use Carbon\Carbon;

class YearlyReport extends Report
{
    /**
     * Parse data into yearly report graph.
     *
     * @param  int|null $userId
     * @return array
     */
    public function make(?int $userId = null)
    {
        foreach ($this->groupByMonth($userId) as $key => $value) {
            $this->count[(int) $key] = count($value);
        }

        $this->countPerMonth();

        return collect($this->graphData);
    }

    /**
     * Group coleted data by month.
     *
     * @param  int|null $userId
     * @return \Illuminate\Support\Collection
     */
    protected function groupByMonth(?int $userId = null)
    {
        return $this->collectDataOf($userId)->select('id', 'created_at')
            ->get()->groupBy(function ($model) {
                return Carbon::parse($model->created_at)->format('m');
            });
    }

    /**
     * Count entreis in a month.
     */
    protected function countPerMonth()
    {
        for ($i = 1; $i <= 12; $i++) {
            if (isset($this->count[$i])) {
                $this->graphData[$i] = $this->count[$i];
            } else {
                $this->graphData[$i] = 0;
            }
        }
    }
}
