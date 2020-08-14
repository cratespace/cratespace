<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Support\Responsibility;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class SubTotalCalculation implements Responsibility
{
    use HasDefaultCharges;

    /**
     * Handle given data and pass it on to next action.
     *
     * @param array    $data
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(array $data, Closure $next)
    {
        $data['subtotal'] = $this->sum($data);

        return $next($data);
    }
}
