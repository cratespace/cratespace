<?php

namespace App\Auth;

use Illuminate\Http\Request;
use App\Guards\LoginRateLimiter;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Hash;
use App\Auth\Traits\HasBeforeSignInAction;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\Auth\Authenticator as AuthenticatorContract;

class Authenticator implements AuthenticatorContract
{
    use HasBeforeSignInAction;

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
     * Create a new user session authenticator instance.
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
     * Authenticate given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function authenticate(Request $request): void
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
        // $this->runBeforeSignIn([$this, $request]);

        $this->checkAccountStatus($request);

        return $this->guard->attempt(
            $request->only($this->username(), 'password'),
            $request->filled('remember')
        );
    }

    /**
     * Determine if the user account is locked.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkAccountStatus(Request $request)
    {
        tap($this->findUser($request), function (Authenticatable $user) use ($request) {
            if ($user->isLocked()) {
                $this->fireFailedEvent($request);

                throw ValidationException::withMessages([$this->username() => [trans('auth.locked')]]);
            }
        });
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
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    protected function ensureLoginIsNotThrottled(Request $request)
    {
        if ($this->limiter->tooManyAttempts($request)) {
            return $this->lockOutUser($request);
        }
    }

    /**
     * Send lockout response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function lockOutUser(Request $request): Response
    {
        event(new Lockout($request));

        return $this->lockOutResponse($request);
    }

    /**
     * Attempt to validate the incoming credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function validateCredentials(Request $request): Authenticatable
    {
        return tap($this->findUser($request), function (Authenticatable $user) use ($request) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                $this->fireFailedEvent($request, $user);

                $this->throwFailedAuthenticationException($request);
            }
        });
    }

    /**
     * Find user trying to attempting to authenticate.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function findUser(Request $request): Authenticatable
    {
        $model = $this->guard->getProvider()->getModel();

        return $model::where(
            $this->username(),
            $request->{$this->username()}
        )->first();
    }

    /**
     * Fire the failed authentication attempt event with the given arguments.
     *
     * @param \Illuminate\Http\Request                        $request
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     *
     * @return void
     */
    protected function fireFailedEvent(Request $request, ?Authenticatable $user = null)
    {
        event(new Failed('web', $user, [
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
    protected function lockOutResponse(Request $request): Response
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
