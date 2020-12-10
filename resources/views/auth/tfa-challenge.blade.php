@extends('layouts.auth')

@section('content')
    <app-section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <logo class="h-16 w-16"></logo>
            </div>

            <div class="mt-6">
                <h2>Confirm sign in</h2>

                <h6><app-link href="{{ route('signup') }}">Sign up</app-link></h6>
            </div>

            <div>
                <tfa-challenge></tfa-challenge>
            </div>
        </div>
    </app-section>
@endsection
