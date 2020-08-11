<?php

namespace App\Billing\Charges\Calculations;

use Closure;
use InvalidArgumentException;
use App\Contracts\Support\Responsibility;
use App\Billing\Charges\Calculations\Traits\HasDefaultCharges;

class PriceCalculation implements Responsibility
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
        if (isset($data['price'])) {
            return $next($data);
        }

        throw new InvalidArgumentException('Product price has not been defined.');
    }
}
