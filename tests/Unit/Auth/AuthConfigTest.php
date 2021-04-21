<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Auth\Config\Auth;

class AuthConfigTest extends TestCase
{
    public function testDynamicallyGetConfigValue()
    {
        config()->set('auth.foo', 'bar');

        $this->assertEquals('bar', Auth::foo());
    }

    public function testReturnsDefaultValueIfConfigValueNotFound()
    {
        $this->assertEquals('bar', Auth::foo('bar'));
    }
}
