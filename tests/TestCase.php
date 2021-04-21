<?php

namespace Tests;

use Tests\Concerns\AuthenticatesUser;
use Tests\Concerns\InteractsWithNetwork;
use Tests\Concerns\InteractsWithProtectedQualities;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AuthenticatesUser;
    use InteractsWithNetwork;
    use InteractsWithProtectedQualities;
}
