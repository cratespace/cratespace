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
            if ($this->hasValidField($feild, $request)) {
                $request->merge([
                    $feild => $this->formatAmount($request->{$feild}),
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Convert monetary amount into centes.
     *
     * @param string $amount
     *
     * @return int
     */
    protected function formatAmount(string $amount): int
    {
        return (int) ($amount * 100);
    }

    /**
     * Determine if the request.
     *
     * @param string                   $feild
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function hasValidField(string $feild, Request $request): bool
    {
        return array_key_exists($feild, $request->all()) &&
            is_numeric($request->{$feild});
    }
}
