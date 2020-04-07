@extends('layouts.master', ['bgcolor' => 'bg-gray-100'])

@section('main')
    <!-- Header -->
    @include('layouts.listings.partials._header')

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials._footer')
@endsection
