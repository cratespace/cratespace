@extends('layouts.app.base')

@section('content')
    @include('business.dashboard.sections._hero')

    @include('business.dashboard.sections._statistics')

    @include('business.dashboard.sections._actions')
@endsection
