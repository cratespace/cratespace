<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class FailedPurchaseResponse extends Response implements Responsable
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
        return $request->expectsJson()
            ? $this->json(['message' => __('Payment failed.')], 204)
            : $this->back(303)->with('status', 'payment-failed');
    }
}
