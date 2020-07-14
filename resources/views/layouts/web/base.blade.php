@extends('layouts.master')

@section('body')
    @include('layouts.web.partials._header')

    @yield('content')

    @include('layouts.web.partials._footer')
@endsection
