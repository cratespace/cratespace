<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Ticket;
use App\Mail\NewTicketCreatedMail;

class NewTicketCreatedEmailTest extends TestCase
{
    /** @test */
    public function it_contains_a_link_to_the_ticket_thread_page()
    {
        $ticket = make(Ticket::class, [
            'code' => 'NEWTICKETSTATUSCODE',
        ]);
        $email = new NewTicketCreatedMail($ticket);
        $rendered = $email->render();

        $this->assertStringContainsString(url('/support/tickets/NEWTICKETSTATUSCODE'), $rendered);
    }

    /** @test */
    public function it_has_a_subject()
    {
        $ticket = make(Ticket::class);
        $email = new NewTicketCreatedMail($ticket);

        $this->assertEquals('New Support Ticket Created', $email->build()->subject);
    }
}
