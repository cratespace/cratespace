<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\Traits\HasBroker;

class PasswordResetLinkController extends Controller
{
    use HasBroker;

    /**
     * Show the reset password link request view.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse
     */
    public function create()
    {
        return view('auth.reset-password-request');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(ResetPasswordRequest $request)
    {
        $status = $this->broker()->sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return $request->wantsJson()
                ? new JsonResponse(['message' => trans($status)], 200)
                : back()->with('status', trans($status));
        }

        if ($request->wantsJson()) {
            throw ValidationException::withMessages(['email' => [trans($status)]]);
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => trans($status)]);
    }
}
