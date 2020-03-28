<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    /** @test */
    public function a_user_can_search_spaces()
    {
        if (! config('scout.algolia.id')) {
            $this->markTestSkipped("Algolia is not configured.");
        }

        config(['scout.driver' => 'algolia']);

        $user = $this->signIn();

        $search = 'foobar7839376';

        $desiredSpace = create(Space::class, [
            'uid' => $search,
            'user_id' => $user->id
        ], 1);
        create(Space::class, ['user_id' => $user->id], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/spaces/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(1, $results);

        Space::all()->unsearchable();
    }

    /** @test */
    public function a_user_can_search_orders()
    {
        if (! config('scout.algolia.id')) {
            $this->markTestSkipped("Algolia is not configured.");
        }

        config(['scout.driver' => 'algolia']);

        $user = $this->signIn();

        $search = 'Jerrold Jenkins';

        $desiredSpace = create(Order::class, [
            'name' => $search,
            'user_id' => $user->id
        ]);
        create(Order::class, ['user_id' => $user->id], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/orders/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(1, $results);

        Order::all()->unsearchable();
    }
}
