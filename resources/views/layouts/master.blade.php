<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cratespace') }} | Get the maximum out of your freight business</title>

    <!-- Styles -->
    @include('layouts.partials._css')
</head>
<body class="text-gray-700 antialiased leading-normal font-sans {{ $bgcolor ?? 'bg-white' }} overflow-x-hidden">
    <!-- Main App -->
    <div id="app">
        @yield('main')
    </div>

    <!-- Scripts -->
    @include('layouts.partials._js')
</body>
</html>
