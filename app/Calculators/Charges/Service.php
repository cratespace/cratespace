<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Service implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(float $price)
    {
        return $this->getServiceRate() / 100 * $price;
    }

    /**
     * Get applicable service rate.
     *
     * @return float
     */
    public function getServiceRate()
    {
        if (config('pricing.rates.service') !== null) {
            return config('pricing.rates.service');
        }

        return 0;
    }
}
