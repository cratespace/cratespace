<?php

namespace App\Http\Middleware;

use Closure;

class CheckForPurchase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (!cache()->has('space')) {
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
