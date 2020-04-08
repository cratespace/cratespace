<?php

namespace App\Analytics;

use Illuminate\Database\Eloquent\Collection;

abstract class Analyzer
{
    /**
     * Model resources currently being analyzed.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $resource;

    /**
     * Status categoreis specific to resource.
     *
     * @var array
     */
    protected $statusList = [];

    /**
     * Create new analytics collector instance.
     *
     * @param \Illuminate\Database\Eloquent\Collection $resource
     */
    public function __construct(Collection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Analize data according to set status.
     *
     * @return array
     */
    public function analyze()
    {
        $counts = [];

        foreach ($this->getStatusList() as $key => $status) {
            $counts[$key] = $this->resource
                ->filter(function ($item) use ($status) {
                    return $item->status === $status;
                })
                ->count();
        }

        return $counts;
    }

    /**
     * Get all registered status categories.
     *
     * @return array
     */
    protected function getStatusList()
    {
        if (isset($this->statusList)) {
            return $this->statusList;
        }

        return [];
    }
}
