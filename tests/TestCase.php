<?php

namespace Tests;

use Tests\Support\AssertEloquent;
use Tests\Support\AssertViewData;
use Illuminate\Foundation\Testing\WithFaker;
use Cratespace\Preflight\Testing\Concerns\CreatesNewUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Cratespace\Preflight\Testing\Concerns\InteractsWithNetwork;
use Cratespace\Preflight\Testing\Concerns\InteractsWithProtectedQualities;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithProtectedQualities;
    use InteractsWithNetwork;
    use CreatesNewUser;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        AssertEloquent::registerMacros();
        AssertViewData::registerMacros();
    }
}
