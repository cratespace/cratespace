<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Auth\Actions\ConfirmPassword;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ConfirmablePasswordController extends Controller
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
     * @param  \Illuminate\Contracts\Auth\StatefulGuard
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the confirm password view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(Request $request): Response
    {
        $confirmed = app(ConfirmPassword::class)(
            $this->guard, $request->user(), $request->input('password')
        );

        if ($confirmed) {
            $request->session()->put('auth.password_confirmed_at', time());
        }

        return $confirmed
            ? $this->passwordConfirmedResponse($request)
            : $this->failedPasswordConfirmationResponse($request);
    }

    /**
     * Password has been confirmed response.
     *
     * @param Request $request
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function passwordConfirmedResponse(Request $request): Response
    {
        return $request->wantsJson()
            ? response()->json('', 201)
            : redirect()->intended(config('auth.defaults.home'));
    }

    /**
     * Password confirmation failed response.
     *
     * @param Request $request [description]
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function failedPasswordConfirmationResponse(Request $request): Response
    {
        $message = __('The provided password was incorrect.');

        if ($request->wantsJson()) {
            throw ValidationException::withMessages(['password' => [$message]]);
        }

        return redirect()->back()->withErrors(['password' => $message]);
    }
}
