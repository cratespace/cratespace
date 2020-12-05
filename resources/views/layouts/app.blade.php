@extends('layouts.master')

@section('body')
    <x-sections.section-header>
        <x-navbars.navbar class="bg-gray-800">
            <x-slot name="logo">
                <div class="leading-none h-8 w-auto">
                    <x-logos.logo-light class="h-8 w-auto"></x-logos.logo-light>
                </div>
            </x-slot>

            <x-slot name="linksLeft">
                <x-navbars.navbar-link class="text-white" href="{{ route('home') }}">Dashboard</x-navbars.navbar-link>
                <x-navbars.navbar-link class="text-white" href="#">Orders</x-navbars.navbar-link>
                <x-navbars.navbar-link class="text-white" href="#">Spaces</x-navbars.navbar-link>
                <x-navbars.navbar-link class="text-white" href="#">Support</x-navbars.navbar-link>
            </x-slot>

            <x-slot name="linksRight">
                <x-dropdowns.dropdown-normal menuDirection="right" class="block md:hidden h-6 w-6">
                    <x-slot name="trigger">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </x-slot>

                    <x-slot name="links">
                        <x-dropdowns.dropdown-item href="{{ route('home') }}">Dashboard</x-dropdowns.dropdown-item>
                        <x-dropdowns.dropdown-item href="#">Orders</x-dropdowns.dropdown-item>
                        <x-dropdowns.dropdown-item href="#">Spaces</x-dropdowns.dropdown-item>
                        <x-dropdowns.dropdown-item href="#">Support</x-dropdowns.dropdown-item>
                    </x-slot>
                </x-dropdowns.dropdown-normal>

                <x-dropdowns.dropdown-normal menuDirection="right" class="ml-4 h-8 w-8">
                    <x-slot name="trigger">
                        <img src="{{ user('profile_photo_url') }}" class="rounded-full block w-8 h-8" alt="{{ user('name') }}">
                    </x-slot>

                    <x-slot name="links">
                        <x-dropdowns.dropdown-item href="{{ route('profile.show') }}">Profile</x-dropdowns.dropdown-item>
                        <sign-out route="{{ route('signout') }}"></sign-out>
                    </x-slot>
                </x-dropdowns.dropdown-normal>
            </x-slot>
        </x-navbars.navbar>
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
                <span class="text-gray-500 text-xs">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            </div>
        </div>
    </x-sections.section-footer>
@endsection
