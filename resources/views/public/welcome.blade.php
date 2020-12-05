@extends('layouts.public')

@section('content')
    <div class="flex items-center justify-between py-5 bg-gray-900 px-6">
        <div class="text-white">
            {{ __('Application ok!') }}
        </div>

        <div class="flex items-center">
            <a href="{{ route('signin') }}">Sign in</a>

            <a class="ml-6" href="{{ route('signout') }}">Sign out</a>
        </div>
    </div>
@endsection
