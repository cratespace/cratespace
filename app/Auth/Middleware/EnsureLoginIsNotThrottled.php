<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use App\Http\Responses\Auth\LockoutResponse;

class EnsureLoginIsNotThrottled extends Authenticate
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
        if (! $this->limiter->tooManyAttempts($request)) {
            return $next($request);
        }

        event(new Lockout($request));

        return app(LockoutResponse::class);
    }
}
