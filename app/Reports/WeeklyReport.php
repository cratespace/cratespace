<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class WeeklyReport extends Report
{
    /**
     * Parse data into yearly report graph.
     *
     * @param int|null $limit
     *
     * @return array
     */
    public function make(?int $limit = null)
    {
        foreach ($this->groupBy() as $item) {
            $this->graphData[
                Carbon::parse($item['date'])->format('D')
            ] = (int) $item['count'];
        }

        if (!is_null($limit)) {
            $this->countFor($limit);
        }

        return collect($this->graphData);
    }

    /**
     * Group coleted data by month.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function groupBy()
    {
        return $this->collection->select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])->whereBetween(
            'created_at',
            [
                Carbon::now()->subDays(30),
                Carbon::now(),
            ]
        )->groupBy('date')
<<<<<<< HEAD
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
=======
        ->orderBy('date', 'ASC')
        ->get()
        ->toArray();
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    }
}
