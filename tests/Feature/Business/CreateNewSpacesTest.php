<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class CreateNewSpacesTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testNewSpaceCanBeCreated()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->post('/spaces', $this->validParameters());

        $response->assertStatus(303);
        $response->assertSessionHasNoErrors();
    }

    public function testNewSpaceCanBeCreatedThroughJsonRequest()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        $response = $this->postJson('/spaces', $this->validParameters());

        $response->assertStatus(201);
    }

    public function testValidDimenssionsAreRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'dimensions' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('dimensions');
        });
    }

    public function testValidWeightIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'weight' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('weight');
        });
    }

    public function testValidOriginIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'origin' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('origin');
        });
    }

    public function testValidDestinationIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'destination' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('destination');
        });
    }

    public function testValidDepartureDateIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'departs_at' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('departs_at');
        });
    }

    public function testValidArrivalDateIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'arrives_at' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('arrives_at');
        });
    }

    public function testValidPriceIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'price' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('price');
        });
    }

    public function testValidTaxIsOptional()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'tax' => '',
        ])), function ($response) {
            $response->assertSessionHasNoErrors();
        });
    }

    public function testValidTypeIsRequired()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'type' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('type');
        });
    }

    public function testBaseIsOptional()
    {
        $user = create(User::class, [], 'asBusiness');

        $this->signIn($user);

        tap($this->post('/spaces', $this->validParameters([
            'base' => '',
        ])), function ($response) {
            $response->assertSessionHasErrors('base');
        });
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
            'dimensions' => [
                'height' => rand(1, 9),
                'width' => rand(1, 9),
                'length' => rand(1, 9),
            ],
            'weight' => rand(1, 9),
            'note' => null,
            'price' => 1000,
            'tax' => 50,
            'type' => $this->faker->randomElement(['Local', 'International']),
            'reserved_at' => null,
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
        ], $overrides);
    }
}
