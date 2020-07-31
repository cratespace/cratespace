<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Contracts\Reports\Report as ReportContract;

class DailyReport extends Report implements ReportContract
{
    /**
     * Table name to query from.
     *
     * @var string
     */
    protected $key = 'time';

    /**
     * Make into report data set.
     *
     * @param int|null $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function make(?int $limit = null): Collection
    {
        return $this->build()->take($limit);
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
