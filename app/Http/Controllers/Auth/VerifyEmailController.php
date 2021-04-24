<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Config\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\Auth\VerifyEmailRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \App\Http\Requests\Auth\VerifyEmailRequest $request
     *
     * @return mixed
     */
    public function __invoke(VerifyEmailRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(Auth::home() . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(Auth::home() . '?verified=1');
    }
}
