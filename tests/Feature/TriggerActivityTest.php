<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Support\Str;

class TriggerActivityTest extends TestCase
{
    /** @test */
    public function creating_a_space_triggers_activity_to_be_recorded()
    {
        $user = $this->signIn();

        $space = create(Space::class);

        $this->assertCount(1, $user->activity);

        tap($user->activity->last(), function ($activity) {
            $this->assertEquals('created_space', $activity->type);

            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_space_triggers_activity_to_be_recorded()
    {
        $user = $this->signIn();

        $space = create(Space::class);
        $originalUid = $space->uid;

        $space->update(['uid' => Str::random(7)]);

        $this->assertCount(2, $user->activity);
    }
}
