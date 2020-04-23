<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;

class LockThreadsTest extends TestCase
{
    /** @test */
    public function non_administrators_may_not_lock_threads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post($thread->path() . '/lock')->assertStatus(302);

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function administrators_can_lock_threads()
    {
        $this->withExceptionHandling();

        $this->signIn(create(User::class, ['type' => 'admin']));

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post($thread->path() . '/lock');

        $this->assertTrue($thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }

    /** @test */
    public function administrators_can_unlock_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn(create(User::class, ['type' => 'admin']));

        $thread = create(Thread::class, ['user_id' => auth()->id(), 'locked' => true]);

        $this->delete($thread->path() . '/unlock');

        $this->assertFalse($thread->fresh()->locked, 'Failed asserting that the thread was unlocked.');
    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class, ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }
}
