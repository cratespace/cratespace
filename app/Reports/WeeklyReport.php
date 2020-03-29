<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WeeklyReport extends Report
{
    /**
     * Parse data into yearly report graph.
     *
     * @param  int|null $userId
     * @return array
     */
    public function make(?int $userId = null)
    {
        foreach ($this->groupByWeek($userId) as $item) {
            $this->graphData[
                Carbon::parse($item['date'])->format('D')
            ] = (int) $item['count'];
        }

        return collect($this->graphData);
    }

    /**
     * Group coleted data by month.
     *
     * @param  int|null $userId
     * @return \Illuminate\Support\Collection
     */
    protected function groupByWeek(?int $userId = null)
    {
        return $this->collectDataOf($userId)->select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
        ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get()
        ->toArray();
    }
}
