<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Services\Stripe\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class AccountInformationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testProfileInformationCanBeUpdated()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/profile', $this->validParameters());

        $response->assertStatus(302);
        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }

    public function testCustomerProfileInformationCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->signIn($user = User::factory()->asCustomer()->create());

        $response = $this->put('/user/profile', $this->validParameters());

        $response->assertStatus(302);
        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
        $customer = new Customer($user->customerId());
        $this->assertEquals('Test Name', $customer->name);
    }

    public function testValidNameIsRequired()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/profile', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateProfileInformation', 'name');
    }

    public function testValidEmailIsRequired()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/profile', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateProfileInformation', 'email');
    }

    public function testValidUsernameIsRequired()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/profile', $this->validParameters([
            'username' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateProfileInformation', 'username');
    }

    public function testValidPhoneIsRequired()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/profile', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrorsIn('updateProfileInformation', 'phone');
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
            'name' => 'Test Name',
            'username' => 'TestUserName',
            'email' => 'test@example.com',
            'phone' => '0775018795',
        ], $overrides);
    }
}
