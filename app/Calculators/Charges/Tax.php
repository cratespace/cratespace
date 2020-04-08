<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Tax implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(float $price)
    {
        return $this->getTaxRate() / 100 * $price;
    }

    /**
     * Get applicable tax rate.
     *
     * @return float
     */
    public function getTaxRate()
    {
        if (config('pricing.rates.tax') !== null) {
            return config('pricing.rates.tax');
        }

        return 0;
    }
}
