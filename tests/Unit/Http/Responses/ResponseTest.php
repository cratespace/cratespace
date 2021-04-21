<?php

namespace Tests\Unit\Http\Responses;

use Tests\TestCase;
use App\Http\Responses\Response;
use Illuminate\Contracts\Support\Responsable;

class ResponseTest extends TestCase
{
    public function testDispatchResponse()
    {
        $response = MockResponse::dispatch('foo');

        $this->assertEquals('foo', $response);
    }
}

class MockResponse extends Response implements Responsable
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
        return $this->content;
    }
}
