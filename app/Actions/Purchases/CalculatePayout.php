<?php

namespace App\Actions\Purchases;

use App\Contracts\Actions\CalculatesAmount;

class CalculatePayout implements CalculatesAmount
{
    /**
     * Calculate required amount.
     *
     * @param int $amount
     *
     * @return int
     */
    public function calculate(int $amount): int
    {
        return (int) ($amount - ($amount * config('defaults.billing.service')));
    }
}
