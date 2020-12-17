@extends('layouts.app')

@section('title')
    <h5 class="text-white font-semibold text-xl leading-none m-0 p-0">
        Profile
    </h5>
@endsection

@section('content')
    <show-profile :data="{{ $user }}"></show-profile>
@endsection
