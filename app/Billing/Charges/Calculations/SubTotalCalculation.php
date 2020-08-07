<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;

class SubTotalCalculation implements CalculationContract
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
        $amounts['subtotal'] = array_sum(array_values($amounts));

        return $next($amounts);
    }
}
