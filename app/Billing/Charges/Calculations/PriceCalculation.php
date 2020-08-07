<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use InvalidArgumentException;
use App\Contracts\Billing\Calculation as CalculationContract;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class PriceCalculation implements CalculationContract
{
    use HasDefaultCharges;

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
