<?php

namespace Tests;

use Tests\Concerns\InteractsWithUserRoles;
use Illuminate\Foundation\Testing\WithFaker;
use Cratespace\Preflight\Testing\Concerns\CreatesNewUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Cratespace\Preflight\Testing\Concerns\InteractsWithNetwork;
use Cratespace\Preflight\Testing\Concerns\InteractsWithProtectedQualities;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithProtectedQualities;
    use InteractsWithUserRoles;
    use InteractsWithNetwork;
    use CreatesNewUser;
    use WithFaker;
}
