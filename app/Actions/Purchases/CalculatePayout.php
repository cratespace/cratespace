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
        return (int) ($amount - ($amount * $this->servicePercentage()));
    }

    /**
     * Get service charge percentage amount.
     *
     * @param float|null $service
     *
     * @return float
     */
    public function servicePercentage(?float $service = null): float
    {
        return config('defaults.billing.service', $service);
    }
}
