@php
    $navbarLinks = [
        url('/') => 'Listings',
        url('/businesses') => 'Businesses',
        url('/pricing') => 'Pricing',
        url('/support') => 'Support',
    ];
@endphp

<x-navbars._web-navbar>
    <x-logos._web-logo>
        <img class="h-10 w-10" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
    </x-logos._web-logo>

    <x-slot name="leftMenu">
        @foreach ($navbarLinks as $link => $name)
            <li class="ml-6">
                <a class="text-sm font-semibold text-gray-600 hover:text-gray-700 focus:text-gray-700 active:text-gray-700" href="{{ $link }}">{{ __($name) }}</a>
            </li>
        @endforeach
    </x-slot>

    <x-slot name="rightMenu">
        <x-dropdowns._normal :extraClasses="'md:hidden'">
            <x-slot name="button">
                <x:heroicon-o-menu class="w-6 h-6 text-white"/>
            </x-slot>

            <x-slot name="menu">
                @foreach ($navbarLinks as $link => $name)
                    <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ $link }}">
                        {{ __($name) }}
                    </a>
                @endforeach

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-sm font-semibold text-blue-500 hover:text-blue-600 focus:text-white active:text-white py-2" href="{{ route('login') }}">{{ __('Sign in') }} <span class="ml-1">&rarr;</span></a>
            </x-slot>
        </x-dropdowns>

        <a class="{{ is_active('/', 'btn btn-secondary px-3 py-0 leading-9', 'font-semibold') }} text-sm hidden md:inline-block" href="@guest {{ route('login') }} @else {{ route('home') }} @endguest">
            @guest()
                <span>{{ __('Sign in') }}</span>
            @else
                <span>{{ __('Dashboard') }}</span>
            @endguest

            <span class="ml-1">&rarr;</span>
        </a>
    </x-slot>
</x-navbars._web-navbar>
