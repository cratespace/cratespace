<?php

namespace App\Contracts;

interface Calculator
{
    /**
     * Calculate price with all applicable charges.
     *
     * @param  int $price
     * @return array
     */
    public function calculate(int $price);
}
