<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;

class ServiceCalculation implements CalculationContract
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
        if (!isset($amounts['subtotal'])) {
            $amounts['service'] = round(array_sum(array_values($amounts)) * $this->getServiceRate(), 2);

            return $next($amounts);
        }

        $amounts['service'] = round($amounts['subtotal'] * $this->getServiceRate(), 2);

        return $next($amounts);
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
