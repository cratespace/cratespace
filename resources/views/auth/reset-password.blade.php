@extends('layouts.auth')

@section('content')
    <app-section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <logo class="h-16 w-16"></logo>
            </div>

            <div class="mt-6">
                <h2>Reset password</h2>

                <h6>Just remembered your password?</span> <app-link href="{{ route('signin') }}">Sign in</app-link></h6>
            </div>

            <div>
                <reset-password token="{{ $token }}"></reset-password>
            </div>
        </div>
    </app-section>
@endsection
