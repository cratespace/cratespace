@extends('layouts.auth')

@section('content')
    <app-section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <logo class="h-16 w-16"></logo>
            </div>

            <div class="mt-6">
                <h2>Welcome back</h2>

                <h6>Don't have an account yet? <app-link href="{{ route('signup') }}">Sign up</app-link></h6>
            </div>

            <div>
                <sign-in></sign-in>
            </div>
        </div>
    </app-section>
@endsection
