<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Authenticator;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\Auth\Authenticator as AuthenticatorContract;

class AuthenticatedSessionController extends Controller
{
    /**
     * User session authenticator.
     *
     * @var \App\Contracts\Auth\Authenticator
     */
    protected Authenticator $authenticator;

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected StatefulGuard $guard;

    /**
     * Create new controller instance.
     *
     * @param \App\Contracts\Auth\Authenticator        $authenticator
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     */
    public function __construct(AuthenticatorContract $authenticator, StatefulGuard $guard)
    {
        $this->authenticator = $authenticator;
        $this->guard = $guard;
    }

    /**
     * Show the login view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        return view('auth.login');
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param \App\Http\Requests\LoginRequest
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(LoginRequest $request): Response
    {
        $this->authenticator->authenticate($request);

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(config('auth.defaults.home'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request): Response
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? response()->json('', 204)
            : redirect('/');
    }
}
