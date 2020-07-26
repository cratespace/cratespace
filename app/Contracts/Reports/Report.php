<?php

namespace App\Contracts\Reports;

use Illuminate\Support\Collection;

interface Report
{
    /**
     * Make into report data set.
     *
     * @param int|null $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function make(?int $limit = null): Collection;

    /**
     * Get time frame of week days.
     *
     * @return array
     */
    public function getTimeframe(): array;
}
