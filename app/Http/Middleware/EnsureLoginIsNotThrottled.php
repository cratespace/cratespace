<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use App\Auth\Guards\LoginRateLimiter;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoginIsNotThrottled
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
        if (! $this->limiter->tooManyAttempts($request)) {
            return $next($request);
        }

        event(new Lockout($request));

        return $this->lockOutResponse($request);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lockOutResponse(Request $request): Response
    {
        return with($this->limiter->availableIn($request), function ($seconds) {
            throw ValidationException::withMessages([
                'email' => [
                    trans('auth.throttle', [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60),
                    ]),
                ],
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        });
    }
}
