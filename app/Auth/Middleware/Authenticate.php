<?php

namespace App\Auth\Middleware;

use App\Auth\Config\Auth;
use Illuminate\Http\Request;
use App\Limiters\LoginRateLimiter;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Actions\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;

abstract class Authenticate
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * The login rate limiter instance.
     *
     * @var \App\Limiters\LoginRateLimiter
     */
    protected $limiter;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @param \App\Limiters\LoginRateLimiter           $limiter
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Make an attempt to authenticate user making request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function attempt(Request $request): bool
    {
        if (app()->has(AuthenticatesUsers::class)) {
            return app(AuthenticatesUsers::class)->authenticate($request);
        }

        return $this->guard->attempt(
            $request->only($this->username(), 'password'),
            $request->filled('remember')
        );
    }

    /**
     * Attempt to validate the incoming credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    protected function validateCredentials(Request $request)
    {
        return tap(
            $this->getAttemptingUser($request),
            function (?Authenticatable $user = null) use ($request) {
                if (! $user || ! Hash::check($request->password, $user->password)) {
                    $this->throwFailedAuthenticationException($request);
                }
            }
        );
    }

    /**
     * Get instance of authenticatable user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Foundation\Auth\User|null
     */
    protected function getAttemptingUser(Request $request): ?User
    {
        return ($this->getAuthModel())::where(
            $this->username(),
            $request->{$this->username()}
        )->first();
    }

    /**
     * Get default authenticatable user model.
     *
     * @return string
     */
    protected function getAuthModel(): string
    {
        return $this->guard->getProvider()->getModel();
    }

    /**
     * Throw a failed authentication validation exception.
     *
     * @param \Illuminate\Http\Request              $request
     * @param \Illuminate\Auth\Authenticatable|null $user
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException(
        Request $request,
        ?Authenticatable $user = null
    ): void {
        $this->limiter->increment($request);

        $this->fireFailedEvent($request, $user);

        throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
    }

    /**
     * Fire the failed authentication attempt event with the given arguments.
     *
     * @param \Illuminate\Http\Request              $request
     * @param \Illuminate\Auth\Authenticatable|null $user
     *
     * @return void
     */
    protected function fireFailedEvent(Request $request, ?Authenticatable $user = null): void
    {
        event(new Failed(Auth::guard(), $user, [
            $this->username() => $request->{$this->username()},
            'password' => $request->password,
        ]));
    }

    /**
     * Get default user attribute treated as username.
     *
     * @return string
     */
    protected function username(): string
    {
        return Auth::username(['email']);
    }
}
