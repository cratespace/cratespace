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
        if (optional($this->validateCredentials($request))->isLocked()) {
            return $request->wantsJson()
                ? response()->json(trans('auth.locked'), 401)
                : redirect()->route('signin')->with('status', trans('auth.locked'));
        }

        return $next($request);
    }
}
