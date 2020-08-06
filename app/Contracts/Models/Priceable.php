<?php

namespace App\Contracts\Models;

interface Priceable
{
    /**
     * Get all amounts to be calculated as charges.
     *
     * @return array
     */
    public function getPriceableAmounts(): array;

    /**
     * Get charge amount as integer and in cents.
     *
     * @param string|int $amount
     *
     * @return int
     */
    public function getChargeAmountInCents($amount): int;
}
