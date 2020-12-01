<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\JsonResponse;

class MiscTest extends TestCase
{
    /** @test */
    public function json_class_and_response_helpers_are_same()
    {
        $jsonResponse = new JsonResponse('', 200);
        $response = response()->json('', 200);

        $this->assertEquals($jsonResponse, $response);
    }
}
