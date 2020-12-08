@extends('layouts.app')

@section('title')
    <x-titles.title-header-section class="text-white">Profile</x-titles.title-header-section>
@endsection

@section('content')
    <update-profile-information-form :user="{{ $user }}"></update-profile-information-form>

    <x-sections.section-border></x-sections.section-border>

    <update-password-form></update-password-form>

    <x-sections.section-border></x-sections.section-border>
@endsection
