<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.title', 'Cratespace') }}</title>

    <!-- Header Scripts -->
    @stack('header-scripts')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased leading-normal font-sans text-gray-600 {{ $bgColor ?? 'bg-white' }} overflow-x-hidden">
    <div id="app">
        <main role="main">
            @yield('body')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
