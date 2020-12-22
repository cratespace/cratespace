<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Contracts\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * User session authenticator.
     *
     * @var \App\Contracts\Auth\AuthenticatesUsers
     */
    protected $authenticator;

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create new controller instance.
     *
     * @param \App\Contracts\Auth\AuthenticatesUsers   $authenticator
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     */
    public function __construct(AuthenticatesUsers $authenticator, StatefulGuard $guard)
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
        return view('auth.signin');
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param \App\Http\Requests\SignInRequest
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(SignInRequest $request): Response
    {
        return $this->authenticator
            ->authenticate($request)
            ->then(function ($request) {
                $intendedUrl = redirect()
                    ->intended(config('auth.defaults.home'))
                    ->getTargetUrl();

                return $request->wantsJson()
                    ? response()->json(['tfa' => false, 'intended' => $intendedUrl])
                    : redirect($intendedUrl);
            });
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
