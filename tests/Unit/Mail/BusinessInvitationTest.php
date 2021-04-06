<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Invitation;
use App\Mail\BusinessInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function testEmailContainsLinkToAcceptInvitation()
    {
        $invitation = create(Invitation::class);

        $email = new BusinessInvitation($invitation);
        $rendered = $email->render($email);

        $this->assertStringContainsString(route('invitations.accept', $invitation), $rendered);
    }

    public function testExpectedSubjectIsPresent()
    {
        $invitation = create(Invitation::class);

        $email = new BusinessInvitation($invitation);

        $this->assertEquals('Cratespace Invitation', $email->build()->subject);
    }
}
