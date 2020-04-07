<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson('/users/' . user('username') . '/notification?status=Unread')->json()
        );
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->post("/users/{$user->username}/notification/read", [
                'notification' => $user->unreadNotifications->first()->id,
            ]);

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
