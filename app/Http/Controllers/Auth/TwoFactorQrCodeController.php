<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwoFactorQrCodeController extends Controller
{
    /**
     * Get the SVG element for the user's two factor authentication QR code.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        return response()->json([
            'svg' => $request->user()->twoFactorQrCodeSvg(),
        ]);
    }
}
