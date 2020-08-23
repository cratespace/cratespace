<?php

namespace Tests\Feature\CustomerSupportExperience;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use Tests\Contracts\Postable;
use App\Mail\NewTicketCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewTicketAssigned;
use Illuminate\Support\Facades\Notification;

class CreateNewTicketTest extends TestCase implements Postable
{
    /** @test */
    public function customers_can_visit_create_new_ticket_page()
    {
        $this->get('support/tickets/create')
            ->assertStatus(200)
            ->assertSee('Contact support');
    }

    /** @test */
    public function customers_can_create_new_ticket()
    {
        $this->withoutExceptionHandling();

        $ticketAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph(7),
        ];

        $postResponse = $this->post('/support/tickets', $ticketAttributes);

        $ticket = Ticket::first();

        $response = $this->get("/support/tickets/{$ticket->code}");

        tap($ticket, function ($ticket) use ($response) {
            $response->assertStatus(200)
                ->assertSee($ticket->code)
                ->assertSee($ticket->name)
                ->assertSee($ticket->email)
                ->assertSee($ticket->subject)
                ->assertSee($ticket->body)
                ->assertSee($ticket->updated_at->diffForHumans());
        });
    }

    /** @test */
    public function a_valid_subject_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/support/tickets/create')
            ->post('/support/tickets', $this->validParameters([
                'subject' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/support/tickets/create')
            ->assertSessionHasErrors('subject');

        $this->assertEquals(0, Ticket::count());
    }

    /** @test */
    public function a_valid_name_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/support/tickets/create')
            ->post('/support/tickets', $this->validParameters([
                'name' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/support/tickets/create')
            ->assertSessionHasErrors('name');

        $this->assertEquals(0, Ticket::count());
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/support/tickets/create')
            ->post('/support/tickets', $this->validParameters([
                'email' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/support/tickets/create')
            ->assertSessionHasErrors('email');

        $this->assertEquals(0, Ticket::count());
    }

    /** @test */
    public function a_valid_phone_number_is_required()
    {
        $response = $this->actingAs(create(User::class))
            ->from('/support/tickets/create')
            ->post('/support/tickets', $this->validParameters([
                'phone' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/support/tickets/create')
            ->assertSessionHasErrors('phone');

        $this->assertEquals(0, Ticket::count());
    }

    /** @test */
    public function an_email_is_sent_to_the_customer_after_ticket_is_created()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $ticket = create(Ticket::class, ['agent_id' => null]);

        Mail::assertQueued(NewTicketCreatedMail::class, function ($mail) use ($ticket) {
            return $mail->hasTo($ticket->customer->email);
        });
    }

    /** @test */
    public function a_notification_with_email_is_sent_to_the_agent_after_ticket_is_created()
    {
        $agent = $this->signIn();
        $agent->assignRole(Role::create(['title' => 'support-agent']));

        Notification::fake();
        Notification::assertNothingSent();

        $ticket = create(Ticket::class, ['agent_id' => $agent->id]);

        Notification::assertSentTo($agent, function (NewTicketAssigned $notification, $channels) use ($ticket) {
            return $notification->ticket->id === $ticket->id;
        });
    }

    /**
     * Array of all valid parameters.
     *
     * @param array $override
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph(7),
            'attachment' => null,
            'user_id' => null,
            'agent_id' => null,
        ], $overrides);
    }
}
