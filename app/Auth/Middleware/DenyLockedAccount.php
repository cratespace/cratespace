<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\Auth\HandleAuthentication;

class DenyLockedAccount extends Authenticate implements HandleAuthentication
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
        $user = $this->getAttemptingUser($request);

        if (! $user->locked) {
            return $next($request);
        }

        $this->throwFailedAuthenticationException($request, $user);
    }
}
