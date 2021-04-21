<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ConfirmPasswordStatusController extends Controller
{
    /**
     * Get the password confirmation status.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'confirmed' => (time() - $request->session()->get('auth.password_confirmed_at', 0)) < $request->input('seconds', config('auth.password_timeout', 900)),
        ]);
    }
}
