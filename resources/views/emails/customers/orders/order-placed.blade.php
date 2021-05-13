@component('mail::message')
{{ __('Hello **:name**,', ['name' => $order->customer->name]) }}

{{ __('We\'re happy to let you know that we’ve **received** your order.') }}

{{ __('Once your order has been confirmed by the associated business, we will send you an email with a confirmation number and link so you can proceed from there.') }}

{{ __('If you have any questions, contact us here or call us on :phone!', [
    'phone' => $order->business->business->phone
]) }}

{{ __('Thank you for using Cratespace.') }}

@component('mail::button', ['url' => $orderUrl])
{{ __('View order details') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to Cratespace, you may discard this email.') }}
@endcomponent
