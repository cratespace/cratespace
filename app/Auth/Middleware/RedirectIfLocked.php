<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfLocked extends Authenticator
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
        $user = $this->validateCredentials($request);

        if ($user->isLocked()) {
            return $request->wantsJson()
                ? response()->json('Account has been locked.', 401)
                : back()->with('status', 'Account has been locked.');
        }

        return $next($request);
    }
}
