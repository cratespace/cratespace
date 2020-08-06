<?php

namespace App\Contracts\Models;

interface Priceable
{
    /**
     * Get charge amount as integer and in cents.
     *
     * @param string|int $amount
     *
     * @return int
     */
    public function getChargeAmountInCents($amount): int;
}
