@component('mail::message')
{{ __('You have been invited to join **Cratespace**!') }}

{{ __('An account has already been created for you with password `:password`, you may accept this invitation by clicking the button below:', [
    'password' => 'CratespaceIsAwesome!'
]) }}

@component('mail::button', ['url' => $acceptUrl])
{{ __('Accept invitation') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to Cratespace, you may discard this email.') }}
@endcomponent
