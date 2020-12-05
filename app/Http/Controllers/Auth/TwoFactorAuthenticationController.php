<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Auth\Actions\EnableTwoFactorAuthentication;
use App\Auth\Actions\DisableTwoFactorAuthentication;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Enable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                        $request
     * @param \App\Auth\Actions\EnableTwoFactorAuthentication $enable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, EnableTwoFactorAuthentication $enable): Response
    {
        $enable($request->user());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'two-factor-authentication-enabled');
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                         $request
     * @param \App\Auth\Actions\DisableTwoFactorAuthentication $disable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request, DisableTwoFactorAuthentication $disable): Response
    {
        $disable($request->user());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'two-factor-authentication-disabled');
    }
}
