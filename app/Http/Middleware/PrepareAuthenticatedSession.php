<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Auth\Guards\LoginRateLimiter;

class PrepareAuthenticatedSession
{
    /**
     * The login rate limiter instance.
     *
     * @var \App\Auth\Guards\LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new class instance.
     *
     * @param \App\Auth\Guards\LoginRateLimiter $limiter
     *
     * @return void
     */
    public function __construct(LoginRateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

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
        $request->session()->regenerate();

        $this->limiter->clear($request);

        return $next($request);
    }
}
