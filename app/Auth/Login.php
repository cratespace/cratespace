<?php

namespace App\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Guards\LoginRateLimiter;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use App\Contracts\Auth\Authenticator;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Login implements Authenticator
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected StatefulGuard $guard;

    /**
     * The login rate limiter instance.
     *
     * @var \App\Guards\LoginRateLimiter
     */
    protected LoginRateLimiter $limiter;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @param \App\Guards\LoginRateLimiter             $limiter
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Handle given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function handle(Request $request): void
    {
        $this->ensureLoginIsNotThrottled($request);

        if (!$this->attemptToAuthenticate($request)) {
            $this->throwFailedAuthenticationException($request);
        }

        $request->session()->regenerate();

        $this->limiter->clear($request);
    }

    /**
     * Attempt to authenticate user login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptToAuthenticate(Request $request): bool
    {
        return $this->guard->attempt(
            $request->only($this->username(), 'password'),
            $request->filled('remember')
        );
    }

    /**
     * Throw a failed authentication validation exception.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException(Request $request): void
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
    }

    /**
     * Ensure login attempt is not throttled.
     *
     * @param \Illuminate\Https\Request $request
     *
     * @return mixed
     */
    protected function ensureLoginIsNotThrottled(Request $request)
    {
        if ($this->limiter->tooManyAttempts($request)) {
            event(new Lockout($request));

            return $this->lockOutResponse($request);
        }
    }

    /**
     * Fire the failed authentication attempt event with the given arguments.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function fireFailedEvent(Request $request): void
    {
        event(new Failed('web', null, [
            $this->username() => $request->{$this->username()},
            'password' => $request->password,
        ]));
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function lockOutResponse(Request $request): SymfonyResponse
    {
        return with($this->limiter->availableIn($request), function ($seconds) {
            throw ValidationException::withMessages([$this->username() => [trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)])]])->status(Response::HTTP_TOO_MANY_REQUESTS);
        });
    }

    /**
     * Default username attribute.
     *
     * @return string
     */
    protected function username(): string
    {
        return config('auth.defaults.username');
    }
}
