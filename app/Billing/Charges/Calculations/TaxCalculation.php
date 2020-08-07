<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;

class TaxCalculation implements CalculationContract
{
    /**
     * Apply charge to amount.
     *
     * @param array|null $amounts
     *
     * @return mixed
     */
    public function apply(array $amounts, Closure $next)
    {
        $amounts['tax'] = round(array_sum(array_values($amounts)) * $this->getTaxRate(), 2);

        return $next($amounts);
    }

    /**
     * Get applicable service rate.
     *
     * @return float
     */
    public function getTaxRate()
    {
        $taxRate = config('defaults.billing.charges.tax');

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
        $serviceChargeRate = config('defaults.billing.charges.service');

        if ($serviceChargeRate !== null) {
            return $serviceChargeRate;
        }

        return 0;
    }
}
