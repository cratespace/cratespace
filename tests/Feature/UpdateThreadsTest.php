<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;

class UpdateThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // $this->withExceptionHandling();

        $this->signIn();
    }

    /** @test */
    public function unauthorized_users_may_not_update_threads()
    {
        $thread = create(Thread::class, ['user_id' => create(User::class)->id]);

        $this->put($thread->path(), [])->assertStatus(403);
    }

    /** @test */
    public function a_thread_requires_a_title_and_body_to_be_updated()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->put($thread->path(), [
            'title' => 'Changed',
        ])->assertSessionHasErrors('body');

        $this->put($thread->path(), [
            'body' => 'Changed',
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $response = $this->put($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body.',
            'channel_id' => $thread->channel->id,
        ]);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed', $thread->title);
            $this->assertEquals('Changed body.', $thread->body);
        });
    }
}
