<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->get('/support/threads/create')
           ->assertRedirect(route('login'));

        $this->post(route('support.threads.store'))
           ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread([
            'title' => 'Some Title',
            'body' => 'Some body.',
        ]);

        $this->get($response->headers->get('Location'))
            ->assertSee('Some Title')
            ->assertSee('Some body.');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        create(Channel::class, [], 2);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, ['title' => 'Foo Title']);

        $this->assertEquals($thread->slug, 'foo-title');
    }

    /**
     * Publish new thread.
     *
     * @param array $overrides
     *
     * @return \Illuminate\Http\Response
     */
    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides + ['user_id' => user('id')]);

        return $this->post(route('support.threads.store'), $thread->toArray());
    }
}
