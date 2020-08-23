@component('mail::message')
# New Support Ticket Assigned

## Hi {{ $ticket->agent->name }},

A new ticket has been assigned to you.

You can view the support ticket details by clicking the button below.

@component('mail::button', ['url' => route('tickets.show', $ticket)])
View ticket details
@endcomponent

@component('mail::footer')
Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
@endcomponent
