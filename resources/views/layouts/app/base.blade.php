@extends('layouts.master', ['bgColor' => 'bg-gray-200'])

@section('body')
    @include('layouts.app.partials._header')

    @yield('content')

    @include('layouts.app.partials._footer')
@endsection
