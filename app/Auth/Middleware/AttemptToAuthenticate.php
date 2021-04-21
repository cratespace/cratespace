<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\Auth\HandleAuthentication;

class AttemptToAuthenticate extends Authenticate implements HandleAuthentication
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->attempt($request)) {
            return $next($request);
        }

        $this->throwFailedAuthenticationException($request);
    }
}
