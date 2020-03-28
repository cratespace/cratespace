<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchSpacesTest extends TestCase
{
    /** @test */
    public function a_user_can_search_spaces()
    {
        config(['scout.driver' => 'algolia']);

        $user = $this->signIn();

        $search = 'foobar7839376';

        $desiredSpace = create(Space::class, [
            'uid' => $search,
            'user_id' => $user->id
        ], 1);
        create(Space::class, ['user_id' => $user->id], 2);

        $results = $this->getJson("/spaces/search?q={$search}")->json();

        $this->assertCount(1, $results['data']);

        Space::all()->unsearchable();
    }
}
