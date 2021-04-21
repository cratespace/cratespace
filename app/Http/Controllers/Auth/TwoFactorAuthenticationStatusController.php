<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\EnableTwoFactorAuthentication;
use App\Actions\Auth\DisableTwoFactorAuthentication;
use App\Http\Responses\Auth\TwoFactorAuthenticationStatusResponse;

class TwoFactorAuthenticationStatusController extends Controller
{
    /**
     * Enable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \App\Actions\EnableTwoFactorAuthentication $enable
     *
     * @return mixed
     */
    public function store(Request $request, EnableTwoFactorAuthentication $enable)
    {
        $enable($request->user());

        return TwoFactorAuthenticationStatusResponse::dispatch(
            'two-factor-authentication-enabled'
        );
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @param \Illuminate\Http\Request                    $request
     * @param \App\Actions\DisableTwoFactorAuthentication $disable
     *
     * @return mixed
     */
    public function destroy(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $disable($request->user());

        return TwoFactorAuthenticationStatusResponse::dispatch(
            'two-factor-authentication-disabled'
        );
    }
}
