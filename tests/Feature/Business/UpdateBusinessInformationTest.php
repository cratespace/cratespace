<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class UpdateBusinessInformationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testBusinessCanUpdateBusinessProfileInformation()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters());

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testBusinessCanUpdateBusinessProfileInformationThroughJsonRequest()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->putJson('/user/business', $this->validParameters());

        $response->assertStatus(204);
    }

    public function testValidNameIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', 'name');
    }

    public function testValidEmailIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', 'email');
    }

    public function testValidPhoneIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', 'phone');
    }

    public function testValidRegistrationNumberIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters([
            'registration_number' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateBusinessInformation', 'registration_number');
    }

    public function testMCCNumberIsOptional()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->put('/user/business', $this->validParameters([
            'mcc' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
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
            'name' => $this->faker->company,
            'email' => $this->faker->email,
            'phone' => '0775018795',
            'registration_number' => rand(9999, 99999),
        ], $overrides);
    }
}
