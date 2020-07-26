<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Contracts\Reports\Report as ReportContract;

class DailyReport extends Report implements ReportContract
{
    /**
     * Make into report data set.
     *
     * @param int|null $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function make(?int $limit = null): Collection
    {
        return $this->query
            ->selectRaw('time(created_at) as time, COUNT(*) as count')
            ->whereBetween(DB::raw('time(created_at)'), $this->getTimeframe())
            ->groupBy('time')
            ->orderBy('time', 'DESC')
            ->get()
            ->take($limit)
            ->pluck('count', 'time');
    }

    /**
     * Get time frame of week days.
     *
     * @return array
     */
    public function getTimeframe(): array
    {
        return [$this->getFromTime(), $this->getTillTime()];
    }

    /**
     * Get time frame starting point.
     *
     * @return string
     */
    protected function getFromTime(): string
    {
        return $this->now()->startOfDay()->toTimeString();
    }

    /**
     * Get time frame ending point.
     *
     * @return string
     */
    protected function getTillTime(): string
    {
        return $this->now()->endOfDay()->toTimeString();
    }

    /**
     * Subtract a day from current date.
     *
     * @return \Carbon\Carbon
     */
    protected function now(): Carbon
    {
        return Carbon::now();
    }
}
