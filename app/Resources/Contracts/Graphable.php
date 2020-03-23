<?php

namespace App\Resources\Contracts;

use Illuminate\Support\Collection;

interface Graphable
{
    /**
     * Parse data into yearly report graph.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return array
     */
    public function make(Collection $data);
}
