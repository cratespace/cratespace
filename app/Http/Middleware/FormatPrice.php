<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FormatPrice
{
    protected static $feilds = [
        'price',
        'tax',
        'total',
        'subtotal',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        foreach (static::$feilds as $feild) {
            if (array_key_exists($feild, $request->all())) {
                $request->{$feild} = $this->formatAmount($request->{$feild});
            }
        }

        return $next($request);
    }

    protected function formatAmount(float $amount): int
    {
        return (int) ($amount * 100);
    }
}
