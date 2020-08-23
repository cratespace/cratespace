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

    /**
     * Instance of UID Generator.
     *
     * @var \App\Support\UidGenerator
     */
    protected $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $generator = new UidGenerator();

        $generator->setOptions([
            'type' => 'orderConfirmationNumber',
            'parameters' => null,
        ]);

        $this->generator = $generator;
    }

    /** @test */
    public function uid_must_be_24_characters_long()
    {
        $this->assertEquals(24, strlen($this->generator->generate()));
    }

    /** @test */
    public function uid_can_only_contain_uppercase_letters_and_numbers()
    {
        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $this->generator->generate());
    }

    /** @test */
    public function uid_cannot_contain_ambiguous_characters()
    {
        $this->assertFalse(strpos($this->generator->generate(), '1'));
        $this->assertFalse(strpos($this->generator->generate(), 'I'));
        $this->assertFalse(strpos($this->generator->generate(), '0'));
        $this->assertFalse(strpos($this->generator->generate(), 'O'));
    }

    /** @test */
    public function uid_must_be_unique()
    {
        $uids = array_map(function ($number) {
            return $this->generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($uids));
    }
}
