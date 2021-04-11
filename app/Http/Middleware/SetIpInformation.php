<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetIpInformation
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
        $request->request->set(
            'ipinfo', app('ipinfo.client')->getDetails($request->ip())
        );

        return $next($request);
    }
}
