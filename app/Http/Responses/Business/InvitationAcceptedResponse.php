<?php

namespace App\Http\Responses\Business;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class InvitationAcceptedResponse extends Response implements Responsable
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
        $token = app(PasswordBroker::class)->createToken($this->content);

        return $request->expectsJson()
            ? $this->json($token, 200)
            : $this->redirectToRoute('password.reset', [
                'email' => $this->content->email,
                'token' => $token,
            ], 303);
    }
}
