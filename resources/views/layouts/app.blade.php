@extends('layouts.master')

@section('body')
    <section-header>
        <navbar class="bg-gray-800">
            <template #logo>
                <logo-light classes="h-8 w-auto" title="{{ config('app.name') }}"></logo-light>
            </template>

            <template #linksleft>
                <navbar-link class="text-white hover:bg-gray-900 focus:bg-gray-900" href="{{ route('home') }}">{{ __('Dashboard') }}</navbar-link>
                <navbar-link class="text-white hover:bg-gray-900 focus:bg-gray-900" href="{{ route('home') }}">{{ __('Spaces') }}</navbar-link>
                <navbar-link class="text-white hover:bg-gray-900 focus:bg-gray-900" href="{{ route('home') }}">{{ __('Orders') }}</navbar-link>
                <navbar-link class="text-white hover:bg-gray-900 focus:bg-gray-900" href="{{ route('home') }}">{{ __('Support') }}</navbar-link>
            </template>

            <template #linksright>
                <dropdown>
                    <template #trigger>
                        <img src="{{ user('profile_photo_url') }}" class="rounded-full block w-8 h-8" alt="{{ user('name') }}">
                    </template>

                    <template #items>
                        <dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</dropdown-link>
                        <dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API tokens') }}</dropdown-link>
                        <dropdown-divider></dropdown-divider>
                        <sign-out>
                            <dropdown-link as="button" type="submit">{{ __('Sign out') }}</dropdown-link>
                        </sign-out>
                    </template>
                </dropdown>
            </template>
        </navbar>
    </section-header>

    <section-title>
        @yield('title')
    </section-title>

    <section-content>
        @yield('content')
    </section-content>

    <section-footer>
        <div class="col-12">
            <div class="text-center">
                <span class="text-gray-500 text-xs">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</span>
            </div>
        </div>
    </section-footer>
@endsection