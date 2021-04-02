<?php

namespace Tests\Unit\Actions;

use Throwable;
use Tests\TestCase;
use App\Models\User;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use App\Actions\Business\InviteBusiness;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteBusinessTest extends TestCase
{
    use RefreshDatabase;

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

        Mail::assertSent(BusinessInvitation::class);

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
            $this->assertInstanceOf(ValidationException::class, $e);

            return;
        }

        $this->fail();
    }

    public function testUserRequiresAnEmail()
    {
        $user = User::factory()->asBusiness()->create();
        $user->email = null;

        try {
            app(InviteBusiness::class)->invite($user);
        } catch (Throwable $e) {
            $this->assertInstanceOf(ValidationException::class, $e);

            return;
        }

        $this->fail();
    }

    public function testCustomerUserCannotBeInvited()
    {
        $user = User::factory()->asCustomer()->create();

        try {
            app(InviteBusiness::class)->invite($user);
        } catch (Throwable $e) {
            $this->assertInstanceOf(ValidationException::class, $e);

            return;
        }

        $this->fail();
    }
}
