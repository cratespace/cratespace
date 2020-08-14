<?php

namespace App\Http\Middleware;

use Closure;

class FormatMoney
{
    /**
     * All key words relating to money amounts.
     *
     * @var array
     */
    protected static $keyWords = ['price', 'tax', 'service', 'subtotal', 'total'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->all() as $key => $value) {
            if (in_array($key, static::$keyWords)) {
                $value = (int) $value * 100;
            }
        }

        return $next($request);
    }
}
