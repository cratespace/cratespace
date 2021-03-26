<?php

namespace Tests\Unit\Models;

use Throwable;
use Tests\TestCase;
use App\Models\User;
use App\Events\BusinessInvited;
use Illuminate\Support\Facades\Event;
use App\Exceptions\UserAlreadyOnboard;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function testABusinessUserCanBeInvited()
    {
        Event::fake();

        $user = User::factory()->asBusiness()->create();

        $user->invite();

        $this->assertTrue($user->invited());
    }

    public function testABusinessInvitedEventIsTriggeredWhenInvited()
    {
        Event::fake();

        $user = User::factory()->asBusiness()->create();

        $user->invite();

        Event::assertDispatched(BusinessInvited::class);

        $this->assertTrue($user->invited());
    }

    public function testAPreviouslyInvitedUserCannotBeReinvited()
    {
        Event::fake();

        $user = User::factory()->asBusiness()->create();

        $user->invite();

        $this->assertTrue($user->invited());

        try {
            $user->invite();
        } catch (Throwable $e) {
            $this->assertInstanceOf(UserAlreadyOnboard::class, $e);
            $this->assertEquals('This user has already been invited', $e->getMessage());

            return;
        }

        $this->fail();
    }
}
