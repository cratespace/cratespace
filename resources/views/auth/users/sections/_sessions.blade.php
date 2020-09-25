<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Sessions
            </h4>

            <p class="text-sm max-w-sm">
                Manage and logout your active sessions on other browsers and devices.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
                <p class="text-sm mb-6">
                    If necessary, you may logout of all of your other browser sessions across all of your devices. If you feel your account has been compromised, you should also update your password.
                </p>

                @if (count($sessions) > 0)
                    <div class="mt-6 space-y-6">
                        <!-- Other Browser Sessions -->
                        @foreach ($sessions as $session)
                            <div class="flex items-center">
                                <div>
                                    @if ($session->agent['is_desktop'])
                                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-500">
                                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                                        </svg>
                                    @endif
                                </div>

                                <div class="ml-3">
                                    <div class="text-sm text-gray-600">
                                        {{ $session->agent['platform'] }} - {{ $session->agent['browser'] }}
                                    </div>

                                    <div>
                                        <div class="text-xs text-gray-500">
                                            {{ $session->ip_address }},

                                            @if ($session->is_current_device)
                                                <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                            @else
                                                {{ __('Last active') }} {{ $session->last_active }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    <button class="btn text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-800 cursor-pointer" type="button" data-toggle="modal" data-toggle="modal" data-target="#sessionFormModal">
                        Sign out other browser sessions
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('modals')
    <x-modals._form-modal :name="'sessionFormModal'" :action="route('other-browser-sessions.destroy')">
        <x-slot name="content">
            @method('DELETE')

            <h5 class="text-lg font-medium text-gray-800 mb-3">
                Logout Other Browser Sessions
            </h5>

            <p class="text-sm text-gray-600">
                Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.
            </p>

            <div class="row">
                <div class="mt-4 col-md-9">
                    @include('components.forms.fields._current-password')
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            <button type="submit" class="btn btn-primary">Sign out other browser sessions</button>
        </x-slot>
    </x-modals._form-modal>
@endpush
