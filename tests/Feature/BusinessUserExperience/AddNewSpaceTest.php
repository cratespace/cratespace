<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Support\Facades\Auth;

class AddNewSpaceTest extends TestCase
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
        $user = $this->signIn();
        $price = rand(1, 9);
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
            'price' => $price,
            'tax' => round($price * 0.05), // 5% tax
            'type' => $this->faker->randomElement(['Local', 'International']),
            'base' => $user->business->country,
        ];

        $response = $this->post('/spaces', $spaceAttributes);

        tap(Space::first(), function ($space) use ($response) {
            $response->assertStatus(302)
                ->assertRedirect($space->path)
                ->assertSee($space->code);
        });
    }
}
