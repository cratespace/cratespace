<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\Concerns\ChecksAuthentication;

class RedirectIfBusiness
{
    use ChecksAuthentication;

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
        if ($this->isAuthenticated($request) && $request->user()->hasRole('Administrator')) {
            return $next($request);
        }

        if ($this->isAuthenticated($request) && ! $request->user()->hasRole('Customer')) {
            return $next($request);
        }

        return response()->redirectToRoute('welcome');
    }
}
