<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Auth\Config\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Inertia\Response as InertiaResponse;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Contracts\Actions\ResetsUserPasswords;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Responses\Auth\PasswordResetResponse;
use App\Http\Responses\Auth\FailedPasswordResetResponse;

class PasswordResetController extends Controller
{
    /**
     * Instance of the password broker implementation.
     *
     * @var \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected $broker;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Auth\PasswordBroker $broker
     *
     * @return void
     */
    public function __construct(PasswordBroker $broker)
    {
        $this->broker = $broker;
    }

    /**
     * Show the new password view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Inertia\InertiaResponse
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Auth/ResetPassword');
    }

    /**
     * Reset the user's password.
     *
     * @param \App\Http\Requests\Auth\PasswordResetRequest $request
     * @param \App\Actions\ResetsUserPasswords             $reseter
     *
     * @return mixed
     */
    public function store(PasswordResetRequest $request, ResetsUserPasswords $reseter)
    {
        $status = $reseter->reset($request->only(
            Auth::email(),
            'password',
            'password_confirmation',
            'token'
        ));

        return $status == Password::PASSWORD_RESET
            ? PasswordResetResponse::dispatch($status)
            : FailedPasswordResetResponse::dispatch($status);
    }
}
