@extends('layouts.master', ['bgcolor' => 'bg-gray-200'])

@section('main')
    <!-- Header -->
    <header class="relative bg-transparent">
        @include('layouts.partials._nav')
    </header>

    <!-- Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Notification -->
    <flash message="{{ session('status') }}"></flash>
@endsection
