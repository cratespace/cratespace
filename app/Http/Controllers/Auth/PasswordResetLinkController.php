<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Auth\Config\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Inertia\Response as InertiaResponse;
use Illuminate\Contracts\Auth\PasswordBroker;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use App\Http\Responses\Auth\FailedPasswordResetLinkRequestResponse;
use App\Http\Responses\Auth\SuccessfulPasswordResetLinkRequestResponse;

class PasswordResetLinkController extends Controller
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
     * Show the reset password link request view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Inertia\InertiaResponse
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(PasswordResetLinkRequest $request): Response
    {
        $status = $this->broker->sendResetLink($request->only(Auth::email()));

        return $status == Password::RESET_LINK_SENT
            ? SuccessfulPasswordResetLinkRequestResponse::dispatch($status)
            : FailedPasswordResetLinkRequestResponse::dispatch($status);
    }
}
