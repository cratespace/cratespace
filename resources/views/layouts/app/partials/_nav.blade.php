<x-navbars._app-navbar>
    <x-logos._app-logo>
        <img class="h-8 w-auto" src="{{ asset('img/logo-light.png') }}" alt="{{ config('app.name') }}">
    </x-logos._app-logo>

    <x-slot name="leftMenu">
        <li>
            <a class="{{ is_active('home', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-gray-600" href="/home">{{ __('Dashboard') }}</a>
        </li>

        <li class="ml-6">
            <a class="{{ is_active('orders*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white" href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
        </li>

        <x-dropdowns._normal :extraClasses="'ml-6'">
            <x-slot name="button">
                <span class="{{ is_active('spaces*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white dropdown-toggle">
                    {{ __('Spaces') }}
                </span>
            </x-slot>

            <x-slot name="menu">
                <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.index') }}">{{ __('All spaces') }}</a>

                <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.create') }}">{{ __('New space') }}</a>
            </x-slot>
        </x-dropdowns>

        <li class="ml-6">
            <a class="{{ is_active('support*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white" href="/support">{{ __('Support') }}</a>
        </li>
    </x-slot>

    <x-slot name="rightMenu">
        <x-dropdowns._normal :extraClasses="'md:hidden'">
            <x-slot name="button">
                <span class="shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden ">
                    <x:heroicon-o-menu class="w-6 h-6 text-gray-600"/>
                </span>
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
                <span class="shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden ">
                    <img class="h-8 w-8" src="{{ user('profile_photo_url') }}" alt="{{ user('name') }}">
                </span>
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
