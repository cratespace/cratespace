@component('mail::message')
# Order Confirmation

## Hi {{ $order->name }}, Thank you for your order!

We've received your order and will contact you as soon as your order is approved by the respective logistics service. In the case your order is rejected, you will be provided with a **full** refund.

You can track your order status by clicking the button below.

@component('mail::button', ['url' => route('orders.confirmation', ['confirmationNumber' => $order->confirmation_number])])
View order status
@endcomponent

@component('mail::footer')
Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
@endcomponent
