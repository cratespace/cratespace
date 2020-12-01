<?php

namespace Tests\Unit\Rules;

use Tests\TestCase;
use App\Rules\Password;
use Illuminate\Support\Str;

class PasswordRuleTest extends TestCase
{
    /** @test */
    public function test_password_rule()
    {
        $rule = new Password();

        $this->assertTrue($rule->passes('password', 'password'));
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

    /** @test */
    public function test_password_rule_can_require_special_characters()
    {
        $rule = new Password();

        $rule->length(8)->requireSpecialCharacter();

        $this->assertTrue($rule->passes('password', 'password!'));
        $this->assertFalse($rule->passes('password', 'password'));

        $this->assertTrue(Str::contains($rule->message(), 'must be at least 8 characters'));
        $this->assertTrue(Str::contains($rule->message(), 'special character'));
    }
}