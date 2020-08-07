<?php

namespace App\Contracts\Billing;

use Closure;

interface Calculation
{
    /**
     * Apply charge to amount.
     *
     * @param array    $amounts
     * @param \Closure $next
     *
     * @return mixed
     */
    public function apply(array $amounts, Closure $next);
}
