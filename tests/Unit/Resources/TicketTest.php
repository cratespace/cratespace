<?php

namespace Tests\Unit\Resources;

use Exception;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;

class TicketTest extends TestCase
{
    /** @test */
    public function it_has_replies()
    {
        $this->assertInstanceOf(Collection::class, create(Ticket::class)->replies);
    }

    /** @test */
    public function it_can_add_replies()
    {
        $ticket = create(Ticket::class);
        $reply = $ticket->addReply([
            'user_id' => create(User::class)->id,
            'agent_id' => null,
            'body' => $this->faker->sentence,
        ]);

        $this->assertTrue($reply->is($ticket->replies->first()));
        $this->assertCount(1, $ticket->replies);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $ticket = create(Ticket::class);

        $this->assertInstanceOf(User::class, $ticket->user);
    }

    /** @test */
    public function it_belongs_to_an_agent()
    {
        $agent = $this->signIn();
        $ticket = create(Ticket::class, ['agent_id' => $agent->id]);

        $this->assertInstanceOf(User::class, $ticket->agent);
    }

    /** @test */
    public function it_can_be_assigned_to_a_user_with_support_agent_role()
    {
        $agent = $this->signIn();
        $supportAgentRole = Role::create(['title' => 'support-agent']);
        $agent->assignRole($supportAgentRole);
        $ticket = create(Ticket::class);
        $ticket->assignTo($agent);

        $this->assertInstanceOf(User::class, $ticket->refresh()->agent);
        $this->assertTrue($agent->is($ticket->refresh()->agent));
    }

    /** @test */
    public function it_will_throw_an_exception_if_user_is_not_a_support_agent()
    {
        $agent = $this->signIn();
        $businessUserRole = Role::create(['title' => 'business-user']);
        $agent->assignRole($businessUserRole);
        $ticket = create(Ticket::class);

        try {
            $ticket->assignTo($agent);
        } catch (Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertFalse($agent->is($ticket->refresh()->agent));

            return;
        }

        $this->fail();
    }

    /** @test */
    public function it_can_generate_a_unique_hasid_for_itself()
    {
        $ticket = create(Ticket::class, ['code' => null]);

        $this->assertNotNull($ticket->code);
    }

    /** @test */
    public function it_has_a_set_of_required_attributes()
    {
        $agent = $this->signIn();
        $supportAgentRole = Role::create(['title' => 'support-agent']);
        $agent->assignRole($supportAgentRole);
        $ticket = create(Ticket::class);

        $this->assertDatabaseHas('tickets', [
            'subject' => $ticket->subject,
            'status' => 'Open',
            'priority' => $ticket->priority,
            'description' => $ticket->description,
            'attachment' => null,
            'user_id' => $ticket->user->id,
            'agent_id' => $ticket->agent->id,
        ]);
    }

    /** @test */
    public function it_has_a_default_status_of_open()
    {
        $agent = $this->signIn();
        $supportAgentRole = Role::create(['title' => 'support-agent']);
        $agent->assignRole($supportAgentRole);
        $ticket = create(Ticket::class);
        $this->assertEquals('Open', $ticket->status);
    }

    /** @test */
    public function it_can_update_its_status()
    {
        $agent = $this->signIn();
        $supportAgentRole = Role::create(['title' => 'support-agent']);
        $agent->assignRole($supportAgentRole);
        $ticket = create(Ticket::class);
        $this->assertEquals('Open', $ticket->status);
        $ticket->mark('Closed');
        $this->assertEquals('Closed', $ticket->refresh()->status);
        $this->assertTrue($ticket->refresh()->marked('Closed'));
    }

    /** @test */
    public function it_is_automatically_assigned_to_an_agent_on_creating()
    {
        $user = $this->signIn();
        Role::create(['title' => 'support-agent']);
        $user->assignRole('support-agent');
        create(Ticket::class, [], 11)->each(function ($ticket) use ($user) {
            $ticket->assignTo($user);
        });
        $ticket = create(Ticket::class);

        $this->assertEquals('Pending', $ticket->status);
    }

    /** @test */
    public function it_is_automatically_assigned_to_an_agent_with_less_than_ten_tickets_assigned()
    {
        $userA = create(User::class);
        $userB = create(User::class);
        $role = Role::create(['title' => 'support-agent']);
        $userA->assignRole($role);
        $userB->assignRole($role);
        create(Ticket::class, ['agent_id' => $userA->id], 11);
        $freeTicket = create(Ticket::class);

        $this->assertTrue($freeTicket->agent->is($userB));
    }
}
