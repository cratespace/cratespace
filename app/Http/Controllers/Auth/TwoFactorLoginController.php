<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\TwoFactorLoginRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorLoginController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuintae\View\View
     */
    public function showLoginChallenge(Request $request)
    {
        return view('auth.two-factor-challenge');
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     *
     * @param \App\Http\Requests\TwoFactorLoginRequest $request
     *
     * @return mixed
     */
    public function login(TwoFactorLoginRequest $request)
    {
        $user = $request->challengedUser();

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return $this->sendFailedLoginResponse($request);
        }

        $this->guard->login($user, $request->remember());

        return $this->sendTwoFactorLoginResponse($request);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedLoginResponse(Request $request): Response
    {
        $message = __('The provided two factor authentication code was invalid.');

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'code' => [$message],
            ]);
        }

        return redirect()->route('login')->withErrors(['email' => $message]);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendTwoFactorLoginResponse(Request $request): Response
    {
        return $request->wantsJson()
            ? response('', 204)
            : redirect()->intended($this->redirectPath());
    }
}
