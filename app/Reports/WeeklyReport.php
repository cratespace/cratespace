<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Contracts\Reports\Report as ReportContract;

class WeeklyReport extends Report implements ReportContract
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
            ->selectRaw('date(created_at) as date, COUNT(*) as count')
            ->whereBetween(DB::raw('date(created_at)'), $this->getTimeframe())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get()
            ->take($limit)
            ->pluck('count', 'date');
    }

    /**
     * Get time frame of week days.
     *
     * @return array
     */
    public function getTimeframe(): array
    {
        return [$this->getFromDate(), $this->getTillDate()];
    }

    /**
     * Get time frame starting point.
     *
     * @return string
     */
    protected function getFromDate(): string
    {
        return $this->subDay()->startOfWeek()->toDateString();
    }

    /**
     * Get time frame ending point.
     *
     * @return string
     */
    protected function getTillDate(): string
    {
        return $this->subDay()->endOfWeek()->toDateString();
    }

    /**
     * Subtract a day from current date.
     *
     * @return \Carbon\Carbon
     */
    protected function subDay(): Carbon
    {
        return Carbon::now()->subDay();
    }
}
