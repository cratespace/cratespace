<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;

class TotalCalculation implements CalculationContract
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
        $total = array_filter($amounts, function ($amount, $name) {
            return $name !== 'price' ? $amount : 0;
        }, ARRAY_FILTER_USE_BOTH);

        $amounts['total'] = round(array_sum(array_values($total)), 2);

        return $next($amounts);
    }
}
