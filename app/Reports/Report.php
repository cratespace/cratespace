<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Builder;

abstract class Report
{
    /**
     * The model to be reported on.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $collection;

    /**
     * Data count per month.
     *
     * @var array
     */
    protected $count = [];

    /**
     * Data to be used in graphing.
     *
     * @var array
     */
    protected $graphData = [];

    /**
     * Create new report instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $collection
     */
    public function __construct(Builder $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Parse data into yearly report graph.
     *
     * @param int|null $limit
     *
     * @return array
     */
    public function make(?int $limit = null)
    {
        foreach ($this->groupBy() as $key => $value) {
            $this->count[(int) $key] = count($value);
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
    abstract protected function groupBy();

    /**
     * Count entreis in a month.
     *
     * @param int $limit
     */
    protected function countFor(int $limit)
    {
        for ($i = 1; $i <= $limit; ++$i) {
            $this->graphData[$i] = isset($this->count[$i])
                ? $this->count[$i] : 0;
        }
    }
}
