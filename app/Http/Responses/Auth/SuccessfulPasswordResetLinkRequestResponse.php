<?php

namespace App\Http\Responses\Auth;

use App\Http\Responses\Response;
use Illuminate\Contracts\Support\Responsable;

class SuccessfulPasswordResetLinkRequestResponse extends Response implements Responsable
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
            ? $this->json(['message' => __($this->content)], 200)
            : $this->redirect()->back()->with('status', __($this->content));
    }
}
