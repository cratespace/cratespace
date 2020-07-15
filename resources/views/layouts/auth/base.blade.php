@extends('layouts.master', [
    'bgcolor' => 'bg-gray-100',
    'title' => 'Cratespace | Let\'s get you started'
])

@section('body')
    <!-- Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Notification -->
    <flash data="{{ session('flash') }}"></flash>
@endsection
