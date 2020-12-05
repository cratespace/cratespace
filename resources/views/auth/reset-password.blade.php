@extends('layouts.auth')

@section('content')
    <x-sections.section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <x-logos.logo class="h-16 w-16"></x-logos.logo>
            </div>

            <div class="mt-6">
                <x-titles.h2>Reset password</x-titles.h2>
            </div>

            <div>
                <x-forms.form action="{{ route('password.update') }}" method="POST" class="w-full">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mt-6 block">
                        <x-forms.inputs.input-email name="email" label="Email address" placeholder="john.farmer@doe.com"></x-forms.inputs.input-email>
                    </div>

                    <div class="mt-6 block">
                        <x-forms.inputs.input-password name="password" id="password" label="Password" placeholder="battleCattleFarmer1589@!"></x-forms.inputs.input-password>
                    </div>

                    <div class="mt-6 block">
                        <x-forms.inputs.input-password name="password_confirmation" id="password-confirm" label="Confirm password" placeholder="battleCattleFarmer1589@!" autocomplete="new-password"></x-forms.inputs.input-password>
                    </div>

                    <div class="mt-6 block">
                        <x-buttons.button-primary type="submit">Reset password</x-buttons.button-primary>
                    </div>
                </x-forms.form>
            </div>

            <div class="mt-6">
                <span class="text-sm text-gray-600">
                    Just remembered your password? <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('signin') }}">Sign in</a>
                </span>
            </div>
        </div>
    </x-sections.section>
@endsection
