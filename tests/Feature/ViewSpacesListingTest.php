<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;

class ViewSpacesListingTest extends TestCase
{
    /** @test */
    public function user_can_view_spaces_listing()
    {
        $this->withoutExceptionHandling();

        $space = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($space->uid);
    }
}
