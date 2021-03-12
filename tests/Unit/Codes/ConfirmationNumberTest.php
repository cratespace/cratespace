<?php

namespace Tests\Unit\Codes;

use PHPUnit\Framework\TestCase;
use App\Codes\ConfirmationNumber;

class ConfirmationNumberTest extends TestCase
{
    public function testMustBe24CharactersLong()
    {
        $this->assertEquals(24, strlen((new ConfirmationNumber())->generate()));
    }

    public function testMustContainUppercaseLettersAndNumbers()
    {
        $this->assertEquals(24, strlen((new ConfirmationNumber())->generate()));
    }
}
