<?php

namespace Tests;

use Tests\Support\CanPlaceOrder;
use Tests\Support\CreatesFakeUser;
use Illuminate\Testing\TestResponse;
use Tests\Support\CalculatesCharges;
use Tests\Support\ChecksForInternet;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;
    use CreatesFakeUser;
    use CalculatesCharges;
    use ChecksForInternet;
    use CanPlaceOrder;

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
