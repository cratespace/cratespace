<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use App\Contracts\Support\Responsibility;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class TotalCalculation implements Responsibility
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
        $total = array_filter($data, function ($amount, $name) {
            return $name !== 'price' ? $amount : 0;
        }, ARRAY_FILTER_USE_BOTH);

        $data['total'] = $this->sum($total);

        return $next($data);
    }
}
