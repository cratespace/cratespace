@extends('layouts.app.base')

@section('content')
    <section class="pt-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                        Billing Settings
                    </h2>

                    <div class="flex items-center text-gray-600">
                        Bill your customers ad hoc with invoices, or bill them on a recurring basis with subscriptions.
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
            <div class="row">
                <div class="col-12">
                    <span class="font-normal text-lg">Information unavailable.</span>
                </div>
            </div>
        </div>
    </section>
@endsection
