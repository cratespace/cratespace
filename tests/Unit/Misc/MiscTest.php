<?php

namespace Tests\Unit\Misc;

use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class MiscTest extends TestCase
{
    /** @test */
    public function json_class_and_response_helpers_are_same()
    {
        $jsonResponse = new JsonResponse('', 200);
        $response = response()->json('', 200);

        $this->assertEquals($jsonResponse, $response);
    }

    /** @test */
    public function generate_hashed_password()
    {
        $password = Hash::make('alphaxion77');

        $this->assertTrue(Hash::check('alphaxion77', $password));
    }
}

