<?php

namespace App\Billing\Charges;

use App\Contracts\Billing\Charges as ChargesContract;

class ServiceCharges implements ChargesContract
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
        return $amount * $this->getServiceRate();
    }

    /**
     * Get applicable service rate.
     *
     * @return float
     */
    public function getServiceRate()
    {
        $serviceChargeRate = config('charges.service');

        if ($serviceChargeRate !== null) {
            return $serviceChargeRate;
        }

        return 0;
    }
}
