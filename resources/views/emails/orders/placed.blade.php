@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => route('orders.confirmation', ['confirmationNumber' => $order->confirmation_number])])
View order status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
