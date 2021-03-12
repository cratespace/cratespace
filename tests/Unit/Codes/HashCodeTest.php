<?php

namespace Tests\Unit\Codes;

use Tests\TestCase;
use App\Codes\HashCode;

class HashCodeTest extends TestCase
{
    public function testCodesGeneratedAreAtLeast6CharactersLong()
    {
        $this->assertTrue(strlen((new HashCode())->generate(1)) >= 6);
    }

    public function testCodesGeneratedCanOnlyContainUppercaseLetters()
    {
        $this->assertMatchesRegularExpression('/^[A-Z]+$/', (new HashCode())->generate(1));
    }

    public function testCodesGeneratedForTheSameResourceIdAreTheSame()
    {
        $code1 = (new HashCode())->generate(1);
        $code2 = (new HashCode())->generate(1);

        $this->assertEquals($code1, $code2);
    }

    public function testCodesGeneratedForDifferentResourceIdsAreDifferent()
    {
        $code1 = (new HashCode())->generate(1);
        $code2 = (new HashCode())->generate(2);

        $this->assertNotEquals($code1, $code2);
    }
}
