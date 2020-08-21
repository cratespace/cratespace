<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Space;

class ViewSpaceListTest extends TestCase
{
    /** @test */
    public function user_can_only_view_thir_own_spaces_listing()
    {
        $spacesOfUser = create(Space::class, ['user_id' => $user = $this->signIn()], 10);
        $spacesNotOfUser = create(Space::class, [], 10);

        $response = $this->get('/spaces');

        foreach ($spacesOfUser as $space) {
            $response->data('resource')->assertContains($space);
        }

        foreach ($spacesNotOfUser as $space) {
            $response->data('resource')->assertDoesNotContain($space);
        }
    }
}
