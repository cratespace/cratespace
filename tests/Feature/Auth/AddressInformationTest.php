<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Services\Stripe\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class AddressInformationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testBusinessUserCanUpdateAddress()
    {
        $user = User::factory()->asBusiness()->create();

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters());

        $response->assertStatus(303);
        $this->assertEquals('Glenquin', $user->fresh()->address->line1);
    }

    public function testBusinessUserCanUpdateAddressThroughJson()
    {
        $user = User::factory()->asBusiness()->create();

        $this->signIn($user);

        $response = $this->putJson('/user/address', $this->validParameters());

        $response->assertStatus(204);
        $this->assertEquals('Glenquin', $user->fresh()->address->line1);
    }

    public function testCustomerUserCanUpdateAddress()
    {
        $user = User::factory()->asCustomer()->create();

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters());

        $response->assertStatus(303);
        $this->assertEquals('Glenquin', $user->fresh()->address->line1);
        $customer = new Customer($user->customerId());
        $this->assertEquals('Glenquin', $customer->address['line1']);
    }

    public function testCustomerUserCanUpdateAddressThroughJson()
    {
        $user = User::factory()->asCustomer()->create();

        $this->signIn($user);

        $response = $this->putJson('/user/address', $this->validParameters());

        $response->assertStatus(204);
        $this->assertEquals('Glenquin', $user->fresh()->address->line1);
        $customer = new Customer($user->customerId());
        $this->assertEquals('Glenquin', $customer->address['line1']);
    }

    public function testValidLine1IsRequired()
    {
        $user = create(User::class);

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters([
            'line1' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateAddressInformation', 'line1');
    }

    public function testValidCityIsRequired()
    {
        $user = create(User::class);

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters([
            'city' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateAddressInformation', 'city');
    }

    public function testValidStateIsRequired()
    {
        $user = create(User::class);

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters([
            'state' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateAddressInformation', 'state');
    }

    public function testValidCountryIsRequired()
    {
        $user = create(User::class);

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters([
            'country' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateAddressInformation', 'country');
    }

    public function testValidPostalcodeIsRequired()
    {
        $user = create(User::class);

        $this->signIn($user);

        $response = $this->put('/user/address', $this->validParameters([
            'postal_code' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateAddressInformation', 'postal_code');
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
            'line1' => 'Glenquin',
            'city' => 'Killinaboy',
            'state' => 'Munster',
            'country' => 'Ireland',
            'postal_code' => '48161',
        ], $overrides);
    }
}
