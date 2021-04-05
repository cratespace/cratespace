<?php

namespace Tests\Unit\Orders;

use PHPUnit\Framework\TestCase;
use App\Orders\GenerateConfirmationNumber;

class GenerateConfirmationNumberTest extends TestCase
{
    /**
     * Order confirmation number.
     *
     * @var string
     */
    protected $number;

    protected function setUp(): void
    {
        parent::setUp();

        $this->number = (new GenerateConfirmationNumber())->generate();
    }

    public function testMustBe24CharactersLong()
    {
        $this->assertEquals(24, strlen($this->number));
    }

    public function testCanOnlyContainUppercaseLettersAndNumbers()
    {
        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $this->number);
    }

    public function testCannotContainAmbiguousCharacters()
    {
        $this->assertFalse(strpos($this->number, '1'));
        $this->assertFalse(strpos($this->number, 'I'));
        $this->assertFalse(strpos($this->number, '0'));
        $this->assertFalse(strpos($this->number, 'O'));
    }

    public function testConfirmationNumbersMustBeUnique()
    {
        $generator = new GenerateConfirmationNumber();

        $this->numbers = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));

        $this->assertCount(100, array_unique($this->numbers));
    }
}
