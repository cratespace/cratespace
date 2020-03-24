<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Service implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(int $price)
    {
        return $this->getServiceRate() / 100 * $price;
    }

    /**
     * Get applicable service rate.
     *
     * @return int
     */
    public function getServiceRate()
    {
        return 1.0;
    }
}
