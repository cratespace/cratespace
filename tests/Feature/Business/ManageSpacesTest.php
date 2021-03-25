<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class ManageSpacesTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testUpdateSpaceDetails()
    {
        $this->withoutExceptionHandling();

        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters());

        $response->assertStatus(303);
        $response->assertSessionHasNoErrors();
    }

    public function testUpdateSpaceDetailsThroughJson()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->putJson("/spaces/{$space->code}", $this->validParameters());

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function testOnlyAuthenticatedUsersCanUpdateSpaceDetails()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);
        auth()->logout();

        $this->assertGuest();

        $response = $this->putJson("/spaces/{$space->code}", $this->validParameters());

        $response->assertStatus(401);
    }

    public function testGuestUsersAreRedirectedToLoginPage()
    {
        $response = $this->put('/spaces/DJFLAUSDLASJDLHJSA', $this->validParameters());

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testRequiresValidDepartsAt()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'departs_at' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('departs_at');
    }

    public function testRequiresValidArrivesAt()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'arrives_at' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('arrives_at');
    }

    public function testRequiresValidOrigin()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'origin' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('origin');
    }

    public function testRequiresValidDestination()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'destination' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('destination');
    }

    public function testRequiresValidHeight()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'height' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('height');
    }

    public function testRequiresValidLength()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'length' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('length');
    }

    public function testRequiresValidWidth()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'width' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('width');
    }

    public function testRequiresValidWeight()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'weight' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('weight');
    }

    public function testRequiresValidPrice()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'price' => 'sadasjndajs',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('price');
    }

    public function testRequiresValidTax()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'tax' => 'sadasjndajs',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('tax');
    }

    public function testTaxIsOptional()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'tax' => '',
        ]));

        $response->assertStatus(303);
    }

    public function testPriceIsConvertedToCents()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'price' => '12.50',
            'base' => $user->address->country,
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($user->id)->first();
        $this->assertEquals(1250, $space->price);
    }

    public function testTaxIsConvertedToCents()
    {
        $this->withoutExceptionHandling();
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put("/spaces/{$space->code}", $this->validParameters([
            'tax' => '0.50',
            'base' => $user->address->country,
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($user->id)->first();
        $this->assertEquals(50, $space->tax);
    }

    public function testSpaceCanBeDeleted()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->delete("/spaces/{$space->code}");

        $response->assertStatus(303);
        $response->assertRedirect('/spaces');
    }

    public function testSpaceCanBeDeletedThroughJson()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->deleteJson("/spaces/{$space->code}");

        $response->assertStatus(204);
    }

    public function testSpaceCanBeDeletedOnlyByOwner()
    {
        $this->signIn($user = User::factory()->asBusiness()->create());
        create(Space::class, ['user_id' => $user->id]);
        $space = create(Space::class);

        $response = $this->delete("/spaces/{$space->code}");

        $response->assertStatus(403);
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
