<?php

namespace App\Http\Responses;

use App\Actions\Customer\DestroyPaymentToken;
use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class PurchaseResponse extends Response implements Responsable
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
        app(DestroyPaymentToken::class)->destroy($request->payment_token);

        return $request->expectsJson()
            ? $this->json()
            : $this->redirectTo('/');
    }
}
