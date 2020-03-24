<?php

namespace App\Reports;

use Carbon\Carbon;

class GraphReport extends Report
{
    /**
     * Data count per month with month number as key.
     *
     * @var array
     */
    protected $graphData = [];

    /**
     * Parse data into yearly report graph.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return array
     */
    public function make()
    {
        foreach ($this->data as $key => $value) {
            $this->count[(int) $key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (isset($this->count[$i])) {
                $this->graphData[$i] = $this->count[$i];
            } else {
                $this->graphData[$i] = 0;
            }
        }

        return collect($this->graphData);
    }
}
