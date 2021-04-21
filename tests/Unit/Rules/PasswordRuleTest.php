<?php

namespace Cratespace\Sentinel\Tests;

use Tests\TestCase;
use App\Rules\PasswordRule;
use Illuminate\Support\Str;

class PasswordRuleTest extends TestCase
{
    public function testPasswordRule()
    {
        $rule = new PasswordRule();

        $this->assertTrue($rule->passes('password', 'password'));
        $this->assertTrue($rule->passes('password', 234234234));
        $this->assertFalse($rule->passes('password', ['foo' => 'bar']));
        $this->assertFalse($rule->passes('password', 'secret'));

        $this->assertTrue(Str::contains($rule->message(), 'must be at least 8 characters'));

        $rule->length(10);

        $this->assertFalse($rule->passes('password', 'password'));
        $this->assertTrue($rule->passes('password', 'password11'));

        $this->assertTrue(Str::contains($rule->message(), 'must be at least 10 characters'));

        $rule->length(8)->requireUppercase();

        $this->assertFalse($rule->passes('password', 'password'));
        $this->assertTrue($rule->passes('password', 'Password'));

        $this->assertTrue(Str::contains($rule->message(), 'characters and contain at least one uppercase character'));

        $rule->length(8)->requireNumeric();

        $this->assertFalse($rule->passes('password', 'Password'));
        $this->assertFalse($rule->passes('password', 'password1'));
        $this->assertTrue($rule->passes('password', 'Password1'));

        $this->assertTrue(Str::contains($rule->message(), 'characters and contain at least one uppercase character and one number'));
    }

    public function testPasswordRuleCanRequireSpecialCharacters()
    {
        $rule = new PasswordRule();

        $rule->length(8)->requireSpecialCharacter();

        $this->assertTrue($rule->passes('password', 'password!'));
        $this->assertFalse($rule->passes('password', 'password'));

        $this->assertTrue(Str::contains($rule->message(), 'must be at least 8 characters'));
        $this->assertTrue(Str::contains($rule->message(), 'special character'));
    }

    public function testPasswordRuleCanRequireNumericAndSpecialCharacters()
    {
        $rule = new PasswordRule();

        $rule->length(10)->requireNumeric()->requireSpecialCharacter();

        $this->assertTrue($rule->passes('password', 'password5%'));
        $this->assertFalse($rule->passes('password', 'my-password'));

        $this->assertTrue(Str::contains($rule->message(), 'must be at least 10 characters'));
        $this->assertTrue(Str::contains($rule->message(), 'contain at least one special character'));
        $this->assertTrue(Str::contains($rule->message(), 'and one number'));
    }
}
