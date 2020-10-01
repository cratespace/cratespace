<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Space;
use Tests\Contracts\Postable;
use Illuminate\Support\Facades\Auth;

class ManageSpacesTest extends TestCase implements Postable
{
    /** @test */
    public function authorized_users_can_only_view_their_own_space_listing()
    {
        $this->get('/spaces')
            ->assertStatus(302)
            ->assertRedirect('/login');

        $user = $this->signIn();
        $spaceOfUser = create(Space::class, ['user_id' => $user->id]);
        $spaceOfAnotherUser = create(Space::class);

        $this->get('/spaces')
            ->assertStatus(200)
            ->assertSee($spaceOfUser->code)
            ->assertDontSee($spaceOfAnotherUser->code);
    }

    /** @test */
    public function only_authorized_users_can_view_edit_space_details_page()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        Auth::logout();

        $this->get($space->path)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->signIn($user);

        $this->get($space->path)->assertStatus(200);
    }

    /** @test */
    public function authorized_users_can_edit_space_details_page()
    {
        $user = $this->signIn();
        $spaceOfUser = create(Space::class, ['user_id' => $user->id]);
        $spaceOfAnotherUser = create(Space::class);
        $edittedSpaceAttributes = [
            'departs_at' => $departsAt = now()->addMonth(),
            'arrives_at' => $arrivesAt = now()->addMonths(rand(2, 3)),
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

        $this->put('/spaces/' . $spaceOfAnotherUser->code, $edittedSpaceAttributes)->assertStatus(403);

        $this->put('/spaces/' . $spaceOfUser->code, $edittedSpaceAttributes)
            ->assertStatus(302)
            ->assertRedirect($spaceOfUser->fresh()->path);

        $response = $this->get('/spaces');

        tap(Space::first(), function ($space) use ($response, $spaceOfUser, $departsAt, $arrivesAt) {
            $response->assertStatus(200)
                ->assertSee($spaceOfUser->refresh()->code)
                ->assertSee($departsAt->diffForHumans())
                ->assertSee($arrivesAt->diffForHumans());
        });
    }

    /** @test */
    public function only_authorized_users_can_delete_spaces()
    {
        $user = $this->signIn();
        $spaceOfUser = create(Space::class, ['user_id' => $user->id]);
        $spaceOfAnotherUser = create(Space::class);

        $this->delete('/spaces/' . $spaceOfAnotherUser->code)
            ->assertStatus(403);

        $this->delete('/spaces/' . $spaceOfUser->code)
            ->assertStatus(302)
            ->assertRedirect('/spaces');
    }

    /** @test */
    public function a_valid_height_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'height' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('height');
    }

    /** @test */
    public function height_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'height' => '12ft tall',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('height');
    }

    /** @test */
    public function a_valid_length_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'length' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('length');
    }

    /** @test */
    public function length_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'length' => '12ft long',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('length');
    }

    /** @test */
    public function a_valid_width_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'width' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('width');
    }

    /** @test */
    public function width_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'width' => '12ft wide',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('width');
    }

    /** @test */
    public function a_valid_weight_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'weight' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('weight');
    }

    /** @test */
    public function weight_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'weight' => '500 tons',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('weight');
    }

    /** @test */
    public function uid_or_hascode_cannot_be_changed()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'code' => 'HDYYENCAIROGHSOYCBAHSDA',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('code');

        $this->assertNotEquals('HDYYENCAIROGHSOYCBAHSDA', $space->refresh()->code);
    }

    /** @test */
    public function additional_information_is_optional()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'note' => '',
            ]));

        tap(Space::first(), function ($space) use ($response, $user) {
            $response->assertRedirect($space->fresh()->path);

            $this->assertTrue($space->user->is($user));
            $this->assertNotNull($space->note);
        });
    }

    /** @test */
    public function departure_datetime_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'departs_at' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('departs_at');
    }

    /** @test */
    public function arrival_datetime_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'arrives_at' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('arrives_at');
    }

    /** @test */
    public function departure_datetime_must_be_a_valid_datetime()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'departs_at' => 'not a valid date',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('departs_at');
    }

    /** @test */
    public function arrival_datetime_must_be_a_valid_datetime()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'arrives_at' => 'also not a valid date',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('arrives_at');
    }

    /** @test */
    public function base_country_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'base' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('base');
    }

    /** @test */
    public function origin_location_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'origin' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('origin');
    }

    /** @test */
    public function type_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'type' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('type');
    }

    /** @test */
    public function only_allowable_type_is_approved()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'type' => 'Universal',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('type');
    }

    /** @test */
    public function price_is_requried()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'price' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function price_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from('/spaces/create')
            ->put("/spaces/{$space->code}", $this->validParameters([
                'price' => 'not valid price',
            ]));

        $response->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function tax_is_optional()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from('/spaces/create')
            ->put("/spaces/{$space->code}", $this->validParameters([
                'tax' => '',
            ]));

        tap(Space::first(), function ($space) use ($response, $user) {
            $response->assertRedirect($space->fresh()->path);

            $this->assertTrue($space->user->is($user));
            // Tax already set on "space-create"
            $this->assertNotNull($space->tax);
        });
    }

    /** @test */
    public function tax_must_be_numeric()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from('/spaces/create')
            ->put("/spaces/{$space->code}", $this->validParameters([
                'tax' => 'not valid tax',
            ]));

        $response->assertRedirect('/spaces/create')
            ->assertSessionHasErrors('tax');
    }

    /** @test */
    public function destination_location_is_required()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->from("/spaces/{$space->code}/edit")
            ->put("/spaces/{$space->code}", $this->validParameters([
                'destination' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect("/spaces/{$space->code}/edit")
            ->assertSessionHasErrors('destination');
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
