@extends('layouts.app')

@section('content')
    <section class="pt-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                        Account Settings
                    </h2>

                    <div class="flex items-center text-gray-600">
                        Customize your experience here at {{ config('app.name') }}.
                    </div>

                    <div class="mt-4">
                        @include('auth.profiles.components._nav', ['user' => $user])
                    </div>

                    <hr class="mt-2 lg:mt-4">
                </div>
            </div>
        </div>
    </section>

    <section class="pt-6 pb-12">
        <div class="container">
            @include('auth.profiles.components.forms._profile', ['user' => $user])

            @include('auth.profiles.components.forms._privacy', ['user' => $user])

            @cannot('admin', $user)
                @include('auth.profiles.components.forms._notifications', ['user' => $user])
            @endcannot

            @include('auth.profiles.components.forms._security', ['user' => $user])
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    @include('auth.profiles.components.modals._delete-confirmation', ['user' => $user])
@endsection
