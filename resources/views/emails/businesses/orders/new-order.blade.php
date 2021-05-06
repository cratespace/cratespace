@component('mail::message')
{{ __('A new order has been placed for space :space', ['space' => 'LGAW47RGL7EO28']) }}

{{ __('An account has already been created for you with password `:password`, you may accept this invitation by clicking the button below:', [
    'password' => 'CratespaceIsAwesome!'
]) }}

@component('mail::button', ['url' => $orderUrl])
{{ __('View order details') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to Cratespace, you may discard this email.') }}
@endcomponent
