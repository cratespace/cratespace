<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ConfirmedPasswordStatusController extends Controller
{
    /**
     * Get the password confirmation status.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request): Response
    {
        return response()->json([
            'confirmed' => (time() - $request->session()->get('auth.password_confirmed_at', 0)) < $request->input('seconds', config('auth.password_timeout', 900)),
        ]);
    }
}
