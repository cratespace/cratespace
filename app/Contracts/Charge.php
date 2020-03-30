<?php

namespace App\Contracts;

interface Charge
{
    /**
     * Apply charge to price.
     *
     * @param  float $price
     * @return float
     */
    public function apply(float $price);
}
