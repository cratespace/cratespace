<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowAdministrator
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
        $isAdmin = ! is_null($request->user()) && $request->user()->isAdmin();

        abort_unless($isAdmin, 403, 'You do not have admin privilages');

        return $next($request);
    }
}
