<?php

namespace App\Contracts\Billing;

interface Charges
{
    /**
     * Apply charge to amount.
     *
     * @param int $amount
     * @param int $taxAmount
     *
     * @return int
     */
    public function apply(int $amount, int $taxAmount = 0): int;
}
