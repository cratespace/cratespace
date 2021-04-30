<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Cratespace\Sentinel\Sentinel\Config as SentinelConfig;
use Cratespace\Sentinel\Contracts\Actions\AuthenticatesUsers;

class AuthenticateUser implements AuthenticatesUsers
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create new authenticate user action instance.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Authenticate user making current request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function authenticate(Request $request): bool
    {
        return $this->guard->attempt(
            $request->only(SentinelConfig::username(), 'password'),
            $request->filled('remember')
        );
    }
}
