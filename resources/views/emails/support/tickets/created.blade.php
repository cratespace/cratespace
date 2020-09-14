@component('mail::message')
# New Support Ticket Created

## Hi {{ $ticket->customer->name }},

We've received your support ticket request, one of our service team representatives will contact you within the next 24 Hrs.

You can track your ticket status by clicking the button below.

@component('mail::button', ['url' => route('tickets.show', $ticket)])
View ticket status
@endcomponent

@component('mail::footer')
Thanks,<br>
{{ config('app.name') }} Support Team
@endcomponent
@endcomponent
