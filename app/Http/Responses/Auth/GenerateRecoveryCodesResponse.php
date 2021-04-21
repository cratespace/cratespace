<?php

namespace App\Http\Responses\Auth;

use App\Http\Responses\Response;
use Illuminate\Contracts\Support\Responsable;

class GenerateRecoveryCodesResponse extends Response implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? $this->json('', 201)
            : $this->back()->with('status', 'recovery-codes-generated');
    }
}
