@extends('layouts.master')

@section('main')
    <!-- Header -->
    @include('layouts.web.partials._header')

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials._footer')
@endsection
