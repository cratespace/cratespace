@component('mail::message')
# Order Status Updated

## Hi {{ $order->name }},

Just wanted to let you know that your order has been "{{ $order->status }}".

You can track your order status by clicking the button below.

@component('mail::button', ['url' => route('orders.confirmation', ['confirmationNumber' => $order->confirmation_number])])
View order status
@endcomponent

@component('mail::footer')
Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
@endcomponent
