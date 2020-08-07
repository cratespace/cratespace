<?php

namespace App\Billing\Charges\Calculations\Traits;

use Illuminate\Support\Arr;

trait HasDefaultCharges
{
    /**
     * Get applicable service rate.
     *
     * @return float
     */
    public function getTaxRate()
    {
        $taxRate = $this->getDefaultCharges('tax');

        if ($taxRate !== null) {
            return $taxRate;
        }

        return 0;
    }

    /**
     * Get applicable service rate.
     *
     * @return float
     */
    public function getServiceRate()
    {
        $serviceChargeRate = $this->getDefaultCharges('service');

        if ($serviceChargeRate !== null) {
            return $serviceChargeRate;
        }

        return 0;
    }

    /**
     * Retrieve default charge percentage amounts from configurations.
     *
     * @param string $charge
     *
     * @return float
     */
    protected function getDefaultCharges(string $charge): float
    {
        return config()->get('defaults.billing.charges.' . $charge);
    }

    /**
     * Sum up given array of charge amounts.
     *
     * @param array $amounts
     *
     * @return float
     */
    protected function sum(array $amounts): float
    {
        if (Arr::isAssoc($amounts)) {
            $amounts = array_values($amounts);
        }

        return array_sum($amounts);
    }
}
