@extends('layouts.master', ['bgColor' => 'bg-gray-200'])

@section('body')
    @include('layouts.web.partials._header')

    @yield('content')

    @include('layouts.web.partials._footer')
@endsection
