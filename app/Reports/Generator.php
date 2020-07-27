<?php

namespace App\Reports;

use App\Reports\Query\Builder;
use Illuminate\Support\Collection;

class Generator
{
    /**
     * Create report generator instance.
     *
     * @param string $key
     * @param bool   $forAuthUser
     */
    public function __construct(string $key, bool $forAuthUser = false)
    {
        $this->key = $key;
        $this->forAuthUser = $forAuthUser;
    }

    /**
     * Generate given report.
     *
     * @param string   $report
     * @param int|null $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function generate(string $report, ?int $limit = null): Collection
    {
        $report = new $report($this->getReportQueryBuilder());

        return $report->make($limit);
    }

    /**
     * Build report query builder instance.
     *
     * @return \App\Reports\Query\Builder
     */
    protected function getReportQueryBuilder(): Builder
    {
        $reportBuilder = new Builder($this->key);

        if ($this->forAuthUser) {
            $reportBuilder->setForAuthurizedOnly();
        }

        $this->reportBuilder = $reportBuilder;

        return $this->reportBuilder;
    }
}
