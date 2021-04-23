<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use Tests\Fixtures\MockStub;

class InputValidationRulesTraitTest extends TestCase
{
    public function testGetRules()
    {
        $stub = new MockStub();

        config()->set('rules.foo', [
            'email' => ['required', 'string', 'email'],
        ]);

        $this->assertEquals(
            ['email' => ['required', 'string', 'email']],
            $this->accessMethod($stub, 'getRulesFor', ['foo'])
        );
    }

    public function testGetRulesWithAdditional()
    {
        $stub = new MockStub();

        config()->set('rules.foo', [
            'email' => ['required', 'string', 'email'],
        ]);

        $this->assertEquals(
            [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string', 'password'],
            ],
            $this->accessMethod($stub, 'getRulesFor', ['foo', [
                'password' => ['required', 'string', 'password'],
            ]])
        );
    }

    public function testGetRulesForMultiple()
    {
        $stub = new MockStub();

        config()->set('rules.foo', [
            'email' => ['required', 'string', 'email'],
        ]);

        config()->set('rules.bar', [
            'name' => ['required', 'string'],
        ]);

        config()->set('rules.baz', [
            'password' => ['required', 'string', 'password'],
        ]);

        $this->assertEquals(
            [
                'email' => ['required', 'string', 'email'],
                'name' => ['required', 'string'],
                'password' => ['required', 'string', 'password'],
            ],
            $this->accessMethod($stub, 'getRulesFor', [['foo', 'bar', 'baz']])
        );
    }

    public function testGetRulesForMultipleWithAdditional()
    {
        $stub = new MockStub();

        config()->set('rules.foo', [
            'email' => ['required', 'string', 'email'],
        ]);

        config()->set('rules.bar', [
            'name' => ['required', 'string'],
        ]);

        config()->set('rules.baz', [
            'password' => ['required', 'string', 'password'],
        ]);

        $this->assertEquals(
            [
                'email' => ['required', 'string', 'email'],
                'name' => ['required', 'string'],
                'password' => ['required', 'string', 'password'],
                'username' => ['required', 'string'],
            ],
            $this->accessMethod($stub, 'getRulesFor', [['foo', 'bar', 'baz'], [
                'username' => ['required', 'string'],
            ]])
        );
    }
}
