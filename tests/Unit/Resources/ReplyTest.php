<?php

namespace Tests\Unit\Resources;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reply;

class ReplyTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->user);
    }

    /** @test */
    public function it_belongs_to_an_agent()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->agent);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_knows_if_who_it_belongs_to()
    {
        $replyOfUser = create(Reply::class, ['agent_id' => null]);
        $this->assertTrue($replyOfUser->by()->is($replyOfUser->user));
        $this->assertFalse($replyOfUser->by()->is($replyOfUser->agent));

        $replyOfAgent = create(Reply::class, ['user_id' => null]);
        $this->assertTrue($replyOfAgent->by()->is($replyOfAgent->agent));
        $this->assertFalse($replyOfAgent->by()->is($replyOfAgent->user));
    }

    /** @test */
    public function a_reply_body_is_sanitized_automatically()
    {
        $reply = make(Reply::class, ['body' => '<script>alert("bad")</script><p>This is okay.</p>']);

        $this->assertEquals('<p>This is okay.</p>', $reply->body);
    }
}
