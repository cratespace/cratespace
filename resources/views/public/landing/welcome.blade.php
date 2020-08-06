@extends('layouts.web.base', ['bgColor' => 'bg-gray-100'])

@section('content')
    @include('public.landing.sections._hero')

    @include('public.landing.sections._query')

    @include('public.landing.sections._spaces')
@endsection
