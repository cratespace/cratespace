<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auth\TwoFactorAuthentication\EnableTwoFactorAuthentication;
use App\Auth\TwoFactorAuthentication\DisableTwoFactorAuthentication;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Enable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                                        $request
     * @param \App\Auth\TwoFactorAuthentication\EnableTwoFactorAuthentication $enable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, EnableTwoFactorAuthentication $enable)
    {
        $enable($request->user());

        return $request->wantsJson()
            ? response('', 200)
            : back()->with('status', 'two-factor-authentication-enabled');
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                                         $request
     * @param \App\Auth\TwoFactorAuthentication\DisableTwoFactorAuthentication $disable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $disable($request->user());

        return $request->wantsJson()
            ? response('', 200)
            : back()->with('status', 'two-factor-authentication-disabled');
    }
}
