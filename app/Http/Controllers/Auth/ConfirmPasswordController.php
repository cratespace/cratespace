<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Contracts\Actions\ConfirmsPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use App\Http\Responses\Auth\PasswordConfirmedResponse;
use App\Http\Responses\Auth\FailedPasswordConfirmationResponse;

class ConfirmPasswordController extends Controller
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
     * Show the confirm password view.
     *
     * @return \Inertia\Response
     */
    public function show(): InertiaResponse
    {
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Confirm the user's password.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(ConfirmPasswordRequest $request, ConfirmsPasswords $confirmer)
    {
        $confirmed = $confirmer->confirm(
            $this->guard,
            $request->user(),
            $request->input('password')
        );

        return $confirmed
            ? PasswordConfirmedResponse::dispatch()
            : FailedPasswordConfirmationResponse::dispatch();
    }
}
