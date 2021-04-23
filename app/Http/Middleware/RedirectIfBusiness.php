<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class RedirectIfBusiness
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
        if (is_null($request->user())) {
            return redirect()->route('login');
        }

        if ($request->user()->isBusiness()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
