@extends('layouts.app')

@section('title')
    <h5 class="text-white font-semibold text-xl leading-none m-0 p-0">
        Profile
    </h5>
@endsection

@section('content')
    <update-profile-information-form :user="{{ $user }}"></update-profile-information-form>

    <section-border></section-border>

    <update-password-form></update-password-form>

    <section-border></section-border>

    <tfa-form :user="{{ $user }}"></tfa-form>

    <section-border></section-border>

    @if (config('session.driver') === 'database')
        <signout-other-browser-sessions-form :sessions="{{ json_encode($user->sessions) }}"></signout-other-browser-sessions-form>

        <section-border></section-border>
    @endif

    <delete-user-form></delete-user-form>
@endsection
