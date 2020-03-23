<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use App\Models\Category;
use Illuminate\Support\Str;

class CreateSpaceTest extends TestCase
{
    /** @test */
    public function only_authenticated_users_can_create_new_spaces()
    {
        $this->get('/spaces/create')->assertRedirect('/login');
        $this->post(route('spaces.store'))->assertStatus(302)->assertRedirect('/login');

        $this->signIn();

        $this->get('/spaces/create')->assertStatus(200);
    }

    /** @test */
    public function users_may_add_new_space()
    {
        $user = $this->signIn();

        $this->get(route('spaces.create'))->assertStatus(200);

        $space = [
            'uid' => Str::random(12),
            'departs_at' => now()->addMonths(1),
            'arrives_at' => now()->addMonths(2),
            'origin' => $this->faker->city,
            'base' => $this->faker->country,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'type' => 'International',
            'status' => 'Available',
            'note' => $this->faker->sentence(7),
            'price' => rand(1, 9),
            'user_id' => $user->id
        ];

        $this->post(route('spaces.store'), $space);

        $this->assertDatabaseHas('spaces', ['uid' => $space['uid']]);

        $this->get(route('spaces.index'))->assertSee($space['uid']);
    }

    /** @test */
    public function a_space_requires_basic_information()
    {
        $user = $this->signIn();

        $this->post(route('spaces.store'), [
            'status' => 'Available',
            'note' => $this->faker->sentence(7),
            'user_id' => $user->id
        ])->assertSessionHasErrors([
            'uid', 'departs_at', 'arrives_at', 'height',
            'width', 'length', 'weight', 'price',
            'origin', 'destination', 'type'
        ]);
    }

    /**
     * Simulate posting to new space store route.
     *
     * @param   array  $overrides
     * @return  \Response
     */
    protected function createSpace($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        return $this->post(
            route('spaces.store'),
            make(Space::class, $overrides)->toArray()
        );
    }
}
