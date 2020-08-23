<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Mail\NewTicketAssignedMail;

class NewTicketAssignedEmailTest extends TestCase
{
    /** @test */
    public function it_contains_a_link_to_the_ticket_thread_page()
    {
        $ticket = make(Ticket::class, [
            'code' => 'NEWTICKETSTATUSCODE',
            'agent_id' => create(User::class)->id,
        ]);
        $email = new NewTicketAssignedMail($ticket);
        $rendered = $email->render();

        $this->assertStringContainsString(url('/support/tickets/NEWTICKETSTATUSCODE'), $rendered);
    }

    /** @test */
    public function it_has_a_subject()
    {
        $ticket = make(Ticket::class, ['agent_id' => create(User::class)->id]);
        $email = new NewTicketAssignedMail($ticket);

        $this->assertEquals('New Support Ticket Assigned', $email->build()->subject);
    }
}
