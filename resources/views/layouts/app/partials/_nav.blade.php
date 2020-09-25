<x-navbars._app-navbar>
    <x-logos._app-logo>
        <img class="h-8 w-auto" src="{{ asset('img/logo-light.png') }}" alt="{{ config('app.name') }}">
    </x-logos._app-logo>

    <x-slot name="leftMenu">
        @foreach ([
                url('/home') => 'Dashboard',
                route('orders.index') => 'Orders',
                url('/support') => 'Support',
            ] as $link => $name)
                <li class="ml-4">
                    <a class="{{ is_active($link, 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-gray-600" href="{{ $link }}">
                        {{ __($name) }}
                    </a>
                </li>
        @endforeach

        <li class="dropdown ml-4">
            <a class="{{ is_active('spaces*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Spaces') }}</a>

            <div class="mt-3 dropdown-menu rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.index') }}">{{ __('All spaces') }}</a>

                <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.create') }}">{{ __('New space') }}</a>
            </div>
        </li>
    </x-slot>

    <x-slot name="rightMenu">
        <x-dropdowns._normal :extraClasses="'md:hidden'">
            <x-slot name="button">
                <x:heroicon-o-menu class="w-6 h-6 text-gray-600"/>
            </x-slot>

            <x-slot name="menu">
                @foreach ([
                        url('/home') => 'Dashboard',
                        route('orders.index') => 'Orders',
                        route('spaces.index') => 'Spaces',
                        url('/support') => 'Support',
                    ] as $link => $name)
                        <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ $link }}">{{ __($name) }}</a>
                @endforeach
            </x-slot>
        </x-dropdowns>

        <x-dropdowns._normal :extraClasses="'ml-4'">
            <x-slot name="button">
                <img class="h-8 w-8" src="{{ user('profile_photo_url') }}" alt="{{ user('name') }}">
            </x-slot>

            <x-slot name="menu">
                @foreach ([
                        route('users.edit', user()) => 'Settings',
                    ] as $link => $name)
                        <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ $link }}">{{ __($name) }}</a>

                        <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Sign out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                @endforeach
            </x-slot>
        </x-dropdowns._normal>
    </x-slot>
</x-navbars._app-navbar>
