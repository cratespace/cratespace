<?php

namespace Tests\Unit\Support;

use App\Support\UidGenerator;
use PHPUnit\Framework\TestCase;

class UidGeneratorTest extends TestCase
{
    // Must be 24 characters long
    // Can only contain uppercase letters and numbers
    // Cannot contain ambiguous characters
    // All order confirmation numbers must be unique
    //
    // ABCDEFGHJKLMNPQRSTUVWXYZ
    // 23456789

    /** @test */
    public function uid_must_be_24_characters_long()
    {
        $generator = new UidGenerator();

        $this->assertEquals(24, strlen($generator->generate()));
    }

    /** @test */
    public function uid_can_only_contain_uppercase_letters_and_numbers()
    {
        $generator = new UidGenerator();

        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $generator->generate());
    }

    /** @test */
    public function uid_cannot_contain_ambiguous_characters()
    {
        $generator = new UidGenerator();

        $this->assertFalse(strpos($generator->generate(), '1'));
        $this->assertFalse(strpos($generator->generate(), 'I'));
        $this->assertFalse(strpos($generator->generate(), '0'));
        $this->assertFalse(strpos($generator->generate(), 'O'));
    }

    /** @test */
    public function uid_must_be_unique()
    {
        $generator = new UidGenerator();

        $uids = array_map(function ($number) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($uids));
    }
}
