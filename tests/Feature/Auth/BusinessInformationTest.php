<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class BusinessInformationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testBusinessInformationCanBeUpdated()
    {
        $this->withExceptionHandling();

        $user = $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters());

        $response->assertStatus(303);

        $this->assertEquals('Example, Co.', $user->business->name);
        $this->assertEquals('Example company profile.', $user->business->description);
    }

    public function testAValidNameIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['name']);
    }

    public function testAValidStreetIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'street' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['street']);
    }

    public function testAValidCityIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'city' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['city']);
    }

    public function testAValidStateIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'state' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['state']);
    }

    public function testAValidCountryIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'country' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['country']);
    }

    public function testAValidPostcodeIsRequired()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'postcode' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', ['postcode']);
    }

    public function testAboutBusinessInformationIsOptional()
    {
        $this->signInUserWithBusiness();

        $response = $this->put('/user/business', $this->validParameters([
            'description' => '',
        ]));

        $response->assertStatus(303);
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Example, Co.',
            'description' => 'Example company profile.',
            'street' => '768 Portal Coast',
            'city' => 'Atlastis',
            'state' => 'Upper Core',
            'country' => 'Saturn',
            'postcode' => '209sda98h3ep',
        ], $overrides);
    }

    /**
     * Create a user with business profile and sign them in as the current authenticated user.
     *
     * @return \App\Models\User
     */
    protected function signInUserWithBusiness(): User
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        return $user;
    }
}
