@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <h3 class="leadin-snug">
                            Settings
                        </h3>

                        <div class="flex items-center text-gray-600">
                            <p class="text-sm">Customize your experience here at {{ config('app.name') }}.</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-6">

            @include('auth.users.sections._profile', ['user' => $user])

            <hr class="my-6">

            @include('auth.users.sections._business', ['user' => $user])

            <hr class="my-6">

            @include('auth.users.sections._address', ['user' => $user])

            <hr class="my-6">

            @include('auth.users.sections._privacy', ['user' => $user])

            <hr class="my-6">

            @include('auth.users.sections._notifications', ['user' => $user])

            <hr class="my-6">

            @include('auth.users.sections._security', ['user' => $user])
        </div>
    </section>
@endsection
