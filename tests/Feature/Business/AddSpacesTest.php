<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class AddSpacesTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testAddNewSpaceDetails()
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        $response = $this->post('/spaces', $this->validParameters([
            'base' => $user->business->country,
        ]));

        $response->assertStatus(303);
    }

    public function testAddNewSpaceDetailsThroughJson()
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        $response = $this->postJson('/spaces', $this->validParameters([
            'base' => $user->business->country,
        ]));

        $response->assertStatus(201);
        $this->assertJson($response->getContent());
    }

    public function testOnlyAuthenticatedUsersCanAddSpaceDetails()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $this->signIn(User::factory()->withBusiness()->create());

        auth()->logout();

        $this->assertGuest();

        $response = $this->post('/spaces', $this->validParameters([
            'base' => 'MockCountry',
        ]));

        $response->assertStatus(302);
    }

    public function testGuestUsersAreRedirectedToLoginPage()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'base' => 'MockCountry',
        ]));

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testAutomaticUniqueHashCodeForSpace()
    {
        $this->signIn($user = User::factory()->withBusiness()->create());

        $response = $this->postJson('/spaces', $this->validParameters([
            'base' => $user->business->country,
        ]));

        $content = json_decode($response->getContent(), true);
        $this->assertIsString($content['code']);
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
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => $this->faker->sentence(7),
            'price' => 10.00,
            'tax' => 0.50,
            'type' => $this->faker->randomElement(['Local', 'International']),
        ], $overrides);
    }
}
