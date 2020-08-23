<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Models\Space;
use App\Support\HashidsCodeGenerator;

class HashidsCodeGeneratorTest extends TestCase
{
    /** @test */
    public function codes_generated_are_at_least_6_characters_long()
    {
        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => create(Space::class)->id,
        ]);

        $this->assertTrue(strlen($hashCodeGenerator->generate()) >= 6);
    }

    /** @test */
    public function codes_generated_can_only_contain_uppercase_letters()
    {
        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => create(Space::class)->id,
        ]);

        $this->assertMatchesRegularExpression('/^[A-Z]+$/', $hashCodeGenerator->generate());
    }

    /** @test */
    public function codes_generated_for_the_same_space_id_are_the_same()
    {
        $space = create(Space::class);
        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => $space->id,
        ]);
        $code1 = $hashCodeGenerator->generate();

        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => $space->id,
        ]);
        $code2 = $hashCodeGenerator->generate();

        $this->assertEquals($code1, $code2);
    }

    /** @test */
    public function codes_generated_for_different_space_ids_are_different()
    {
        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => create(Space::class)->id,
        ]);
        $code1 = $hashCodeGenerator->generate();

        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => env('APP_KEY'),
            'id' => create(Space::class)->id,
        ]);
        $code2 = $hashCodeGenerator->generate();

        $this->assertNotEquals($code1, $code2);
    }
}
