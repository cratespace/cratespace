<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Config\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cratespace\Sentinel\Contracts\Responses\VerifyEmailViewResponse;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|Illuminate\Contracts\Support\Responsable
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(Auth::home())
            : $this->app(VerifyEmailViewResponse::class);
    }
}
