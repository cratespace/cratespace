<?php

namespace App\Reports;

use App\Reports\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class Report
{
    /**
     * Instance of report query builder instance.
     *
     * @var \App\Reports\Query\Builder
     */
    protected $query;

    /**
     * Table name to query from.
     *
     * @var string
     */
    protected $key;

    /**
     * Create new report instance.
     *
     * @param \App\Reports\Query\Builder $query
     */
    public function __construct(Builder $query)
    {
        $this->query = $query->build();
    }

    /**
     * Make query builder into collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return $this->getQuery()->get();
    }

    /**
     * Builder report.
     *
     * @return \Illuminate\Support\Collection
     */
    public function build(): Collection
    {
        return $this->getQuery()
            ->selectRaw($this->makeRawStatement())
            ->whereBetween(DB::raw($this->getKeyFunction()), $this->getTimeframe())
            ->groupBy($this->key)
            ->orderBy($this->key, 'DESC')
            ->get()
            ->pluck('count', $this->key);
    }

    /**
     * Make select raw statement.
     *
     * @return string
     */
    protected function makeRawStatement(): string
    {
        return "{$this->getKeyFunction()} as {$this->key}, COUNT(*) as count";
    }

    /**
     * Get report query builder instance.
     *
     * @return \App\Reports\Query\Builder
     */
    public function getQuery(): QueryBuilder
    {
        return $this->query;
    }

    /**
     * Get date/time function.
     *
     * @return string
     */
    protected function getKeyFunction(): string
    {
        return "{$this->key}(created_at)";
    }
}
