@extends('layouts.master', ['bgcolor' => 'bg-gray-200'])

@section('main')
    <!-- Header -->
    @include('layouts.app.partials._header')

    <!-- Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Notification -->
    <flash message="{{ session('status') }}"></flash>
@endsection
