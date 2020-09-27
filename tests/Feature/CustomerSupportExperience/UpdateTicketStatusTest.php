<?php

namespace Tests\Feature\CustomerSupportExperience;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketStatusUpdatedMail;

class UpdateTicketStatusTest extends TestCase
{
    /** @test */
    public function an_email_is_sent_to_the_user_after_ticket_status_is_updated()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $agent = $this->signIn();
        $supportAgentRole = Role::create(['title' => 'support-agent']);
        $agent->assignRole($supportAgentRole);
        $ticket = create(Ticket::class);

        $this->actingAs($agent)->put(
            "/support/tickets/{$ticket->code}",
            ['status' => 'Closed']
        );

        $this->assertEquals('Closed', $ticket->refresh()->status);

        Mail::assertQueued(TicketStatusUpdatedMail::class, function ($mail) use ($ticket) {
            return $mail->hasTo($ticket->user->email);
        });
    }
}
