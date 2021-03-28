<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\Concerns\ChecksAuthentication;

class RedirectIfCustomer
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
        if ($this->isAuthenticated($request) && $request->user()->hasRole('Customer')) {
            return response()->redirectToRoute('welcome');
        }

        return $next($request);
    }
}
