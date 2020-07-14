@extends('layouts.master', ['bgcolor' => 'bg-gray-100'])

@section('body')
    <!-- Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Notification -->
    <flash data="{{ session('flash') }}"></flash>
@endsection
