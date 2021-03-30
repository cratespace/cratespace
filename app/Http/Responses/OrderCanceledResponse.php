<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class OrderCanceledResponse extends Response implements Responsable
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
            ? $this->json(['message' => __('Order cancelled')])
            : $this->back(303)->with('status', 'order-cancelled');
    }
}
