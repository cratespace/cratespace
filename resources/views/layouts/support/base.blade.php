@extends('layouts.master')

@section('main')
    <!-- Header -->
    @include('layouts.support.partials._header')

    <!-- Content -->
    <main role="main">
        @yield('content')
    </main>

    <footer>
        @include('layouts.support.partials._footer')
    </footer>

    <!-- Notification -->
    <flash message="{{ session('status') }}"></flash>
@endsection
