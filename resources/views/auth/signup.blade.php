@extends('layouts.auth')

@section('content')
    <app-section>
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div>
                <logo class="h-16 w-16"></logo>
            </div>

            <div class="mt-6">
                <h2>Let's get you started</h2>

                <h6>Already have an account? <app-link href="{{ route('signin') }}">Sign in</app-link></h6>
            </div>

            <div>
                <sign-up></sign-up>
            </div>
        </div>
    </app-section>
@endsection
