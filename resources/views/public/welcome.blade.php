@extends('layouts.public')

@section('header')
    <navbar class="bg-blue-800">
        <template #logo>
            <a href="/" class="inline-block">
                <logo-light classes="h-8 w-auto" title="{{ config('app.name') }}"></logo-light>
            </a>
        </template>

        <template #linksleft>
            <navbar-link class="text-white hover:bg-blue-900" href="{{ route('home') }}">Dashboard</navbar-link>
            <navbar-link class="text-white hover:bg-blue-900" href="{{ url('/spaces') }}">Spaces</navbar-link>
            <navbar-link class="text-white hover:bg-blue-900" href="{{ url('/orders') }}">Orders</navbar-link>
            <navbar-link class="text-white hover:bg-blue-900" href="{{ url('/support') }}">Support</navbar-link>
        </template>

        <template #linksright>
            @auth
                <dropdown>
                    <template #trigger>
                        <img src="{{ asset('img/default.jpg') }}" class="rounded-full block w-10 h-10" alt="user">
                    </template>

                    <template #items>
                        <dropdown-link href="{{ route('profile.show') }}">Profile</dropdown-link>
                        <dropdown-link href="{{ route('signout') }}">Signout</dropdown-link>
                    </template>
                </dropdown>
            @else
                <navbar-link class="text-white hover:bg-blue-900" href="{{ route('signin') }}">Sign in</navbar-link>
                <navbar-link class="text-white hover:bg-blue-900" href="{{ route('signup') }}">Sign up</navbar-link>
            @endauth
        </template>
    </navbar>
@endsection

@section('content')
    <section class="py-16 bg-gray-200">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="row justify-center">
                <div class="col-12">
                    <!-- Content -->
                </div>
            </div>
        </div>
    </section>
@endsection
