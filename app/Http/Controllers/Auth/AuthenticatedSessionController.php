<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Authenticator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
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
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param \App\Http\Requests\LoginRequest
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect('/');
    }
}
