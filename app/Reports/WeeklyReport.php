<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Contracts\Reports\Report as ReportContract;

class WeeklyReport extends Report implements ReportContract
{
    /**
     * Table name to query from.
     *
     * @var string
     */
    protected $key = 'date';

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
        return [$this->getFromDate(), $this->getTillDate()];
    }

    /**
     * Get time frame starting point.
     *
     * @return string
     */
    protected function getFromDate(): string
    {
        return $this->subDay()->startOfWeek(Carbon::MONDAY)->toDateString();
    }

    /**
     * Get time frame ending point.
     *
     * @return string
     */
    protected function getTillDate(): string
    {
        return $this->subDay()->endOfWeek(Carbon::SUNDAY)->toDateString();
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
