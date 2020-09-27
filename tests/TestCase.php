<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    use Concerns\CreatesFakeUser;
    use Concerns\CalculatesCharges;
    use Concerns\ChecksForInternet;
    use Concerns\CanPlaceOrder;
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

    /**
     * Assert that a validation exception is thrown.
     *
     * @param \Illuminate\Testing\TestResponse $response
     * @param string                           $key
     *
     * @return \Illuminate\Testing\TestResponse
     */
    public function assertValidationError(TestResponse $response, string $key)
    {
        return $response->assertStatus(422)->assertSessionMissing($key);
    }
}
