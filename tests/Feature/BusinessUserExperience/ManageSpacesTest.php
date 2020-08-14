<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Support\Facades\Auth;

class ManageSpacesTest extends TestCase
{
    /** @test */
    public function authorized_users_can_only_view_their_own_space_listing()
    {
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
            'code' => 'FAKESPACEFORTESTING',
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
            ->assertRedirect('/spaces');

        $response = $this->get('/spaces');

        tap(Space::first(), function ($space) use ($response, $departsAt, $arrivesAt) {
            $response->assertStatus(200)
                ->assertSee('FAKESPACEFORTESTING')
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
}
