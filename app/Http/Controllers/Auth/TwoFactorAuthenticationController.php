<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\Auth\TwoFactorLoginRequest;
use App\Http\Responses\Auth\TwoFactorLoginResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\Auth\FailedTwoFactorLoginResponse;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
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
     * Show the two factor authentication challenge view.
     *
     * @param \App\Http\Requests\TwoFactorLoginRequest $request
     *
     * @return \Inertia\Response
     */
    public function create(TwoFactorLoginRequest $request): InertiaResponse
    {
        if (! $request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('login'));
        }

        return Inertia::render('Auth/TwoFactorChallenge');
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     *
     * @param \Sentinel\Http\Requests\TwoFactorLoginRequest $request
     *
     * @return mixed
     */
    public function store(TwoFactorLoginRequest $request)
    {
        $user = $request->challengedUser();

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return FailedTwoFactorLoginResponse::dispatch();
        }

        $this->guard->login($user, $request->remember());

        $request->session()->regenerate();

        return TwoFactorLoginResponse::dispatch();
    }
}
