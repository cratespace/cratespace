<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Auth\Traits\HasBroker;

class PasswordResetLinkController extends Controller
{
    use HasBroker;

    /**
     * Show the reset password link request view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('auth.reset-password-request');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(ResetPasswordRequest $request): Response
    {
        $status = $this->broker()->sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return $request->wantsJson()
                ? response()->json(['message' => trans($status)], 200)
                : back()->with('status', trans($status));
        }

        if ($request->wantsJson()) {
            throw ValidationException::withMessages(['email' => [trans($status)]]);
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => trans($status)]);
    }
}
