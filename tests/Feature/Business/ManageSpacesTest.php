<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Products\Line\Space as SpaceProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class ManageSpacesTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testSpaceDetailsCanBeUpdated()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, [
            'user_id' => $user->id,
            'height' => 10,
        ]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'height' => 20,
            ])
        );

        $response->assertStatus(303);

        $this->assertEquals(20, $space->fresh()->height);
    }

    public function testSpaceDetailsCanBeUpdatedThroughJsonRequest()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, [
            'user_id' => $user->id,
            'height' => 10,
        ]);

        $response = $this->putJson(
            "/spaces/{$space->code}",
            $this->validParameters([
                'height' => 20,
            ])
        );

        $response->assertStatus(200);

        $this->assertEquals(20, $space->fresh()->height);
    }

    public function testValidHeightIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'height' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('height');
    }

    public function testValidWidthIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'width' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('width');
    }

    public function testValidLengthIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'length' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('length');
    }

    public function testValidWeightIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'weight' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('weight');
    }

    public function testValidOriginIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'origin' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('origin');
    }

    public function testValidDestinationIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'destination' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('destination');
    }

    public function testValidDepartureIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'departs_at' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('departs_at');
    }

    public function testValidArrivalIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'arrives_at' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('arrives_at');
    }

    public function testValidTypeIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->put(
            "/spaces/{$space->code}",
            $this->validParameters([
                'type' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('type');
    }

    public function testSpaceCanBeDeleted()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->delete("/spaces/{$space->code}");

        $response->assertStatus(303);

        $this->assertNull($space->fresh());
    }

    public function testReservedSpaceCannnotBeDeleted()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $space = create(Space::class, ['user_id' => $user->id]);
        $space = SpaceProduct::find($space->id);
        $space->reserve();

        $response = $this->delete("/spaces/{$space->code}");

        $response->assertStatus(403);

        $this->assertNotNull($space->fresh());
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
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => null,
            'price' => 1000,
            'tax' => 50,
            'type' => $this->faker->randomElement(['Local', 'International']),
            'reserved_at' => null,
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => $this->faker->city . ', ' . $this->faker->country,
            'destination' => $this->faker->city . ', ' . $this->faker->country,
        ], $overrides);
    }
}
