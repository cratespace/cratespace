<?php

namespace App\Http\Controllers\Auth\Concerns;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Middleware\AttemptToAuthenticate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\EnsureLoginIsNotThrottled;
use App\Http\Middleware\PrepareAuthenticatedSession;
use App\Http\Middleware\RedirectIfTwoFactorAuthenticatable;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): Response
    {
        return $this->loginPipeline($request)->then(function (LoginRequest $request) {
            if ($response = $this->authenticated($request, $this->guard()->user())) {
                return $response;
            }

            return $request->wantsJson()
                ? response()->json(['two_factor' => false])
                : redirect()->intended($this->redirectPath());
        });
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, Authenticatable $user)
    {
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request): Response
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson() ? new Response('', 204) : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }

    /**
     * Get the authentication pipeline instance.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request): Pipeline
    {
        return (new Pipeline(app()))
            ->send($request)
            ->through(array_filter([
                config('auth.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                RedirectIfTwoFactorAuthenticatable::class,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]));
    }
}
