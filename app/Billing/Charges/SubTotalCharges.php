<?php

namespace App\Billing\Charges;

use App\Contracts\Billing\Charges as ChargesContract;

class SubTotalCharges implements ChargesContract
{
    /**
     * Apply charge to amount.
     *
     * @param int $amount
     * @param int $taxAmount
     *
     * @return int
     */
    public function apply(int $amount, int $taxAmount = 0): int
    {
        return $amount;
    }
}
