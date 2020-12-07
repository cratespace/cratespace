@extends('layouts.auth')

@section('content')
    <x-sections.section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <x-logos.logo class="h-16 w-16"></x-logos.logo>
            </div>

            <div class="mt-6">
                <x-titles.h2>Reset password</x-titles.h2>

                <p class="mt-4">
                    Enter the email address associated with your account and we'll send you a link to reset your password.
                </p>
            </div>

            <div>
                @if (session('status'))
                    <div class="mt-1" role="alert">
                        <span class="font-medium text-xs text-green-500">{{ session('status') }}</span>
                    </div>
                @else
                    <x-forms.form action="{{ route('password.email') }}" method="POST" class="w-full">
                        <div class="mt-6 block">
                            <x-forms.inputs.input-email name="email" label="Email address" placeholder="john@doe.com"></x-forms.inputs.input-email>
                        </div>

                        <div class="mt-6 block">
                            <x-buttons.button-primary type="submit">Request password reset link</x-buttons.button-primary>
                        </div>
                    </x-forms.form>
                @endif
            </div>

            <div class="mt-6">
                <span class="text-sm text-gray-600">
                    Just remembered your password? <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('signin') }}">Sign in</a>
                </span>
            </div>
        </div>
    </x-sections.section>
@endsection
