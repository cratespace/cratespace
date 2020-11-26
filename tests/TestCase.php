<?php

namespace Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    use Concerns\CreatesFakeUser;
    use Concerns\ChecksForInternet;
    use Concerns\TestsProtectedQualities;
    use Concerns\HasMacros;

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
