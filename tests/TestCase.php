<?php

namespace Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use CreatesApplication;

    use Concerns\HasMacros;
    use Concerns\CreatesFakeUser;
    use Concerns\ChecksForInternet;
    use Concerns\TestsProtectedQualities;

    /**
     * Setup test suite.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Schema::enableForeignKeyConstraints();

        $this->registerMacros();
    }
}
