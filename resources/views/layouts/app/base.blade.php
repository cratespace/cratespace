@extends('layouts.master')

@section('body')
    @include('layouts.app.partials._header')

    @yield('content')

    @include('layouts.app.partials._footer')
@endsection
