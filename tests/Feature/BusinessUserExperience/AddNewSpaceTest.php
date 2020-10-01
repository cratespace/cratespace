<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Tests\Contracts\Postable;
use Illuminate\Support\Facades\Auth;

class AddNewSpaceTest extends TestCase implements Postable
{
    /** @test */
    public function only_authenticated_users_can_visit_add_new_space_page()
    {
        $user = $this->signIn();

        $this->get('/spaces/create')
            ->assertStatus(200)
            ->assertSee('Add New Space');

        Auth::logout();

        $this->get('/spaces/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_add_new_space()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $spaceAttributes = [
            'code' => 'FAKESPACEFORTESTING',
            'departs_at' => now()->addMonth(),
            'arrives_at' => now()->addMonths(rand(2, 3)),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => $this->faker->sentence(7),
            'price' => $price = rand(1, 9),
            'tax' => round($price * 0.05), // 5% tax
            'type' => $this->faker->randomElement(['Local', 'International']),
            'base' => $user->business->country,
        ];

        $postResponse = $this->post('/spaces', $spaceAttributes);

        $response = $this->get('/spaces');

        tap(Space::first(), function ($space) use ($response) {
            $response->assertStatus(200)
                ->assertSee($space->code)
                ->assertSee($space->schedule->departsAt)
                ->assertSee($space->departs_at->diffForHumans())
                ->assertSee($space->schedule->arrivesAt)
                ->assertSee($space->arrives_at->diffForHumans());
        });
    }

    /** @test */
    public function guests_cannot_add_space_details()
    {
        $this->post('/spaces', $this->validParameters())
            ->assertRedirect('/login')
            ->assertSTatus(302);

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function a_valid_height_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'height' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('height');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function height_must_be_numeric()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'height' => '12ft tall',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('height');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function a_valid_length_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'length' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('length');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function length_must_be_numeric()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'length' => '12ft long',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('length');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function a_valid_width_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'width' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('width');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function width_must_be_numeric()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'width' => '12ft wide',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('width');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function a_valid_weight_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'weight' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('weight');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function weight_must_be_numeric()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'weight' => '500tons',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('weight');

        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function uid_or_hascode_is_optional()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'code' => '',
            ]));

        tap(Space::first(), function ($space) use ($response, $user) {
            $response->assertRedirect($space->path);

            $this->assertTrue($space->user->is($user));
            $this->assertNotNull($space->code);
        });
    }

    /** @test */
    public function additional_information_is_optional()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'note' => '',
            ]));

        tap(Space::first(), function ($space) use ($response, $user) {
            $response->assertRedirect($space->path);

            $this->assertTrue($space->user->is($user));
            $this->assertNull($space->note);
        });
    }

    /** @test */
    public function departure_datetime_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'departs_at' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('departs_at');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function arrival_datetime_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'arrives_at' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('arrives_at');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function departure_datetime_must_be_a_valid_datetime()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'departs_at' => 'not a date',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('departs_at');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function arrival_datetime_must_be_a_valid_datetime()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'arrives_at' => 'not a date',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('arrives_at');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function base_country_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'base' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('base');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function origin_location_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'origin' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('origin');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function type_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'type' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('type');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function only_allowable_type_is_approved()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'type' => 'Not allowable',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('type');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function price_is_requried()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'price' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('price');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function price_must_be_numeric()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'price' => 'not valid price',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('price');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function tax_is_optional()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'tax' => '',
            ]));

        tap(Space::first(), function ($space) use ($response, $user) {
            $response->assertRedirect($space->path);

            $this->assertTrue($space->user->is($user));
            $this->assertNull($space->tax);
        });
    }

    /** @test */
    public function tax_must_be_numeric()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'tax' => 'not valid tax',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('tax');
        $this->assertEquals(0, Space::count());
    }

    /** @test */
    public function destination_location_is_required()
    {
        $response = $this->actingAs($user = create(User::class))
            ->from('/spaces/create')
            ->post('/spaces', $this->validParameters([
                'destination' => '',
            ]));

        $response->assertRedirect('/spaces/create');
        $response->assertSessionHasErrors('destination');
        $this->assertEquals(0, Space::count());
    }

    /**
     * Array of all valid parameters.
     *
     * @param array $override
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'code' => 'FAKESPACEFORTESTING',
            'departs_at' => now()->addMonth(),
            'arrives_at' => now()->addMonths(rand(2, 3)),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => $this->faker->sentence(7),
            'price' => $price = rand(1, 9),
            'tax' => round($price * 0.05), // 5% tax
            'type' => $this->faker->randomElement(['Local', 'International']),
            'base' => 'Sri Lanka',
        ], $overrides);
    }
}
