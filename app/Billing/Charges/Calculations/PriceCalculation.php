<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use InvalidArgumentException;
use App\Contracts\Billing\Calculation as CalculationContract;

class PriceCalculation implements CalculationContract
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
        if (isset($amounts['price'])) {
            return $next($amounts);
        }

        throw new InvalidArgumentException('Product price has not been defined.');
    }
}
