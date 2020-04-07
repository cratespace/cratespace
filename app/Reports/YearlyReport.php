<?php

namespace App\Reports;

use Carbon\Carbon;

final class YearlyReport extends Report
{
    /**
     * Group coleted data by month.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function groupBy()
    {
        return $this->collection->select('id', 'created_at')
            ->get()->groupBy(function ($model) {
                return Carbon::parse($model->created_at)->format('m');
            });
    }
}
