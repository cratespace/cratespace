@component('mail::message')
# Support Ticket Status Updated

## Hi {{ $ticket->customer->name }},

Your support request is now {{ strtolower($ticket->status) }}.

You can track your ticket status by clicking the button below.

@component('mail::button', ['url' => route('tickets.show', $ticket)])
View ticket status
@endcomponent

@component('mail::footer')
Thanks,<br>
{{ config('app.name') }} Support Team
@endcomponent
@endcomponent
