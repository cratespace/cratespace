<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Models\Activity;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_records_activity_when_a_space_is_created()
    {
        $this->signIn();

        $space = create(Space::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_space',
            'user_id' => user('id'),
            'subject_id' => $space->id,
            'subject_type' => Space::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $space->id);
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create(Space::class, ['user_id' => user('id')], 2);

        user()->activity()
              ->first()
              ->update([
                'created_at' => Carbon::now()->subWeek()
              ]);

        $feed = Activity::feed(user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('F j, Y')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('F j, Y')
        ));
    }
}
