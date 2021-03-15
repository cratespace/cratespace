<?php

namespace App\Contracts\Actions;

interface CalculatesAmount
{
    /**
     * Calculate required amount.
     *
     * @param int $amount
     *
     * @return int
     */
    public function calculate(int $amount): int;
}
