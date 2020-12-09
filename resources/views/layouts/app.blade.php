@extends('layouts.master')

@section('body')
    <x-sections.section-header>
        <navbar class="bg-gray-800">
            <template #logo>
                <a href="/" class="inline-block" title="{{ config('app.name') }}">
                    <x-logos.logo-light class="h-8 w-auto" alt="{{ config('app.name') }}"></x-logos.logo-light>
                </a>
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
                        <form @submit.prevent="signOut">
                            <dropdown-link as="button" type="submit">{{ __('Sign out') }}</dropdown-link>
                        </form>
                    </template>
                </dropdown>
            </template>
        </navbar>
    </x-sections.section-header>

    <x-sections.section-app-title>
        @yield('title')
    </x-sections.section-app-title>

    <x-sections.section-app>
        @yield('content')
    </x-sections.section-app>

    <x-sections.section-footer>
        <div class="col-12">
            <div class="text-center">
                <span class="text-gray-500 text-xs">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</span>
            </div>
        </div>
    </x-sections.section-footer>
@endsection
