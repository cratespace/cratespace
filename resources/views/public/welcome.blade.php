@extends('layouts.public')

@section('header')
    <navbar>
        <template slot="logo">
            <a href="/" class="inline-block">
                <x-logos.logo class="h-10 w-10"></x-logos.logo>
            </a>
        </template>

        <template slot="linksLeft">
            <navbar-link class="text-gray-300" href="{{ route('home') }}">Dashboard</navbar-link>
            <navbar-link class="text-gray-300" href="{{ url('/spaces') }}">Spaces</navbar-link>
            <navbar-link class="text-gray-300" href="{{ url('/orders') }}">Orders</navbar-link>
            <navbar-link class="text-gray-300" href="{{ url('/support') }}">Support</navbar-link>
        </template>

        <template slot="linksRight">
            @auth
                <dropdown>
                    <template slot="trigger">
                        <img src="{{ asset('img/default.jpg') }}" class="rounded-full block w-10 h-10" alt="user">
                    </template>

                    <template slot="items">
                        <dropdown-link href="{{ route('profile.show') }}">Profile</dropdown-link>
                        <dropdown-link href="{{ route('signout') }}">Signout</dropdown-link>
                    </template>
                </dropdown>
            @else
                <navbar-link class="text-gray-300" href="{{ route('signin') }}">Sign in</navbar-link>
                <navbar-link class="text-gray-300" href="{{ route('signup') }}">Sign up</navbar-link>
            @endauth
        </template>
    </navbar>
@endsection

@section('content')
    <!-- Content -->
@endsection
