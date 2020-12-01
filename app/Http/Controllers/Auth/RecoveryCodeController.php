<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auth\Actions\GenerateNewRecoveryCodes;
use Symfony\Component\HttpFoundation\Response;

class RecoveryCodeController extends Controller
{
    /**
     * Get the two factor authentication recovery codes for authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request): Response
    {
        if (!$request->user()->two_factor_secret ||
            !$request->user()->two_factor_recovery_codes) {
            return [];
        }

        return response()->json(json_decode(decrypt(
            $request->user()->two_factor_recovery_codes
        ), true));
    }

    /**
     * Generate a fresh set of two factor authentication recovery codes.
     *
     * @param \Illuminate\Http\Request                          $request
     * @param \Laravel\Fortify\Actions\GenerateNewRecoveryCodes $generate
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, GenerateNewRecoveryCodes $generate): Response
    {
        $generate($request->user());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'recovery-codes-generated');
    }
}
