<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\Auth\Authenticator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;

class RedirectIfLocked
{
    /**
     * User session authenticator.
     *
     * @var \App\Contracts\Auth\Authenticator
     */
    protected Authenticator $authenticator;

    /**
     * Create a new middleware instance.
     *
     * @param \App\Contracts\Auth\Authenticator $authenticator
     *
     * @return void
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
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
        if ($response = $this->checkAccountStatus($request)) {
            return $response;
        }

        return $next($request);
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
    protected function checkAccountStatus(Request $request)
    {
        tap($this->authenticator->findUser($request), function (Authenticatable $user) use ($request) {
            if ($user->isLocked()) {
                $this->authenticator->fireFailedEvent($request, $user);

                throw ValidationException::withMessages([$this->authenticator->username() => [trans('auth.locked')]]);
            }
        });
    }
}
