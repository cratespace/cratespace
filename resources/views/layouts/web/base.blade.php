@extends('layouts.master', ['bgColor' => 'bg-gray-100'])

@section('body')
    @include('layouts.web.partials._header')

    @yield('content')

    @include('layouts.web.partials._footer')
@endsection
