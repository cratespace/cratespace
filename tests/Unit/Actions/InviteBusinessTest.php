<?php

namespace Tests\Unit\Actions;

use Throwable;
use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Exceptions\InvitationException;
use App\Actions\Business\InviteBusiness;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteBusinessTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testBusinessUserCanBeInvited()
    {
        Event::fake();
        Mail::fake();

        $user = User::factory()->asBusiness()->create();

        app(InviteBusiness::class)->invite($user);

        $this->assertTrue($user->invited());
    }

    public function testInvitationMailIsSent()
    {
        Event::fake();
        Mail::fake();

        $user = User::factory()->asBusiness()->create();

        app(InviteBusiness::class)->invite($user);

        Mail::assertQueued(BusinessInvitation::class);

        $this->assertTrue($user->invited());
    }

    public function testPreviouslyInvitedBusinessesCannotBeInvitedANew()
    {
        Event::fake();

        $user = User::factory()->asBusiness()->create();

        $user->invite();

        try {
            app(InviteBusiness::class)->invite($user);
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvitationException::class, $e);

            return;
        }

        $this->fail();
    }

    public function testCustomerUserCannotBeInvited()
    {
        $user = m::mock(User::class);
        $user->shouldReceive('isCustomer')
            ->once()
            ->andReturn(true);

        try {
            app(InviteBusiness::class)->invite($user);
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvitationException::class, $e);

            return;
        }

        $this->fail();
    }
}
