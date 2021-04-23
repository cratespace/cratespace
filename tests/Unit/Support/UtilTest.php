<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Models\User;
use App\Support\Util;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilTest extends TestCase
{
    use RefreshDatabase;

    public function testGetClassNameFromKeyWord()
    {
        $this->assertEquals('Normal', Util::className('normals'));
    }

    public function testGetAlpha2CountryName()
    {
        $this->assertEquals('NL', Util::alpha2('Netherlands'));
    }

    public function testMakeUsername()
    {
        $this->assertEquals(
            'JamesSilverman',
            Util::makeUsername('James Silverman')
        );
    }

    public function testMakeUniqueUsername()
    {
        $user = create(User::class, ['username' => 'JamesSilverman']);

        $this->assertNotEquals(
            $user->username,
            Util::makeUsername('James Silverman')
        );
    }
}
