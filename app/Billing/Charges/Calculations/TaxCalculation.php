<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class TaxCalculation implements CalculationContract
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
        $amounts['tax'] = round($this->sum($amounts) * $this->getTaxRate(), 2);

        return $next($amounts);
    }
}
