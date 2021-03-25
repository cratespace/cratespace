<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Cratespace\Sentinel\Http\Responses\Response;

class SpaceResponse extends Response implements Responsable
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
        if (is_null($this->content)) {
            return $request->expectsJson()
                ? $this->json('', 204)
                : $this->redirectToRoute('spaces.index', [], 303);
        }

        return $request->expectsJson()
            ? $this->json($this->content, $request->method() === 'PUT' ? 200 : 201)
            : $this->redirectTo($this->content->path, 303);
    }
}
