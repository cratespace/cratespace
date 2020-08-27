<?php

namespace App\Reports;

use App\Reports\Query\Builder;
use App\Exceptions\OptionsNotSetException;
use App\Contracts\Support\Generator as GeneratorContract;

class Generator implements GeneratorContract
{
    /**
     * Generator options.
     *
     * @var array
     */
    protected $options = [];

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
     * Set generator options.
     *
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options = []): void
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return $this->getReport()->make($this->options['limit']);
    }

    /**
     * Resolve report type form set options.
     *
     * @return \App\Contracts\Reports\Report
     *
     * @throws \App\Exceptions\OptionsNotSetException
     */
    protected function getReport()
    {
        if (isset($this->options['report'])) {
            $report = $this->options['report'];

            return is_string($report)
                ? new $report($this->getReportQueryBuilder())
                : $report;
        }

        throw new OptionsNotSetException('Report type not set');
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
