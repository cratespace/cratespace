<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfCustomer
{
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
        abort_if(is_null($request->user()), 403);

        if ($request->user()->isCustomer()) {
            return redirect(url('/'));
        }

        return $next($request);
    }
}
