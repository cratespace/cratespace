<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Billing\Calculation as CalculationContract;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class ServiceCalculation implements CalculationContract
{
    use HasDefaultCharges;

    /**
     * Apply charge to amount.
     *
     * @param array    $amounts
     * @param \Closure $next
     *
     * @return mixed
     */
    public function apply(array $amounts, Closure $next)
    {
        $subtotal = $amounts['subtotal'] ?? $this->sum($amounts);

        $amounts['service'] = $subtotal * $this->getServiceRate();

        return $next($amounts);
    }
}
