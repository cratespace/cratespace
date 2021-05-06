<?php

namespace App\Http\Responses\Business;

use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class OrderResponse extends Response implements Responsable
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
        if ($request->expectsJson()) {
            return $this->json($this->content ?? '', 200);
        }

        return $request->method() === 'DELETE'
            ? $this->redirectToRoute('orders.index')
            : $this->back(303);
    }
}
