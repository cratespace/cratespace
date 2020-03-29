<?php

namespace App\Contracts;

interface Charge
{
    /**
     * Apply charge to price.
     *
     * @param  int $price
     * @return int
     */
    public function apply(int $price);
}
