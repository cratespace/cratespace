@component('mail::message')
{{ __('Hello **:name,**', ['name' => $order->business->name]) }}

{{ __('A new order has been placed for space [**:space**](:url) and is awaiting your confirmation.', [
    'space' => $order->orderable->code,
    'url' => $orderUrl
]) }}

{{ __('Please note that your orders and transactions will not proceed unless you confirm the order.') }}

{{ __('If you would like to contact the customer who placed the order, you may find the customer details below.') }}

{{ __('**:name**', ['name' => $order->customer->name]) }}<br />
{{ __('[:email](mailto::email)', ['email' => $order->customer->email]) }}<br />
{{ __(':phone', ['phone' => $order->customer->phone]) }}

@component('mail::button', ['url' => $orderUrl])
{{ __('View order details') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to Cratespace, you may discard this email.') }}
@endcomponent
