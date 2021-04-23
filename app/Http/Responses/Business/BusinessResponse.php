<?php

namespace App\Http\Responses\Business;

use App\Http\Responses\Response;
use Illuminate\Contracts\Support\Responsable;

class BusinessResponse extends Response implements Responsable
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
        return $request->expectsJson() ? $this->json() : $this->redirectTo('/');
    }
}
