<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request): Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? response()->json('', 204)
                : redirect()->intended(config('auth.defaults.home'));
        }

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? response()->json('', 202)
            : back()->with('status', 'verification-link-sent');
    }
}
