<?php

namespace App\Http\Responses\Auth;

use App\Auth\Config\Auth;
use App\Http\Responses\Response;
use App\Limiters\LoginRateLimiter;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class LockoutResponse extends Response implements Responsable
{
    /**
     * The login rate limiter instance.
     *
     * @var \App\Limiters\LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new response instance.
     *
     * @param \App\Limiters\LoginRateLimiter $limiter
     *
     * @return void
     */
    public function __construct(LoginRateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return with($this->limiter->availableIn($request), function ($seconds) {
            throw ValidationException::withMessages([
                Auth::username() => [
                    trans('auth.throttle', [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60)
                    ])
                ]
            ])->status(SymfonyResponse::HTTP_TOO_MANY_REQUESTS);
        });
    }
}
