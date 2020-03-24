<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Tax implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(int $price)
    {
        return $this->getTaxRate() / 100 * $price;
    }

    /**
     * Get applicable tax rate.
     *
     * @return int
     */
    public function getTaxRate()
    {
        return 0.5;
    }
}
