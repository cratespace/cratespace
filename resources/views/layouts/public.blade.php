@extends('layouts.master')

@section('body')
    <header id="header">
        @yield('header')
    </header>

    <main id="content" role="main">
        @yield('content')
    </main>

    <footer id="footer">
        @yield('footer')
    </footer>
@endsection
