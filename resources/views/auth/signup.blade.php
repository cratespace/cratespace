@extends('layouts.auth')

@section('content')
    <x-sections.section>
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div>
                <x-logos.logo class="h-16 w-16"></x-logos.logo>
            </div>

            <div class="mt-6">
                <x-titles.h2>Let's get you started</x-titles.h2>

                <x-titles.h6>
                    Already have an account? <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('signin') }}">Sign in</a>
                </x-titles.h6>
            </div>

            <div>
                <x-forms.form action="{{ route('signup') }}" method="POST" class="w-full">
                    <div class="row">
                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-text name="name" label="Full name" placeholder="Johnathan Doe"></x-forms.inputs.input-text>
                        </div>

                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-text name="business" label="Business name" placeholder="Cratespace, Inc."></x-forms.inputs.input-text>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-email name="email" label="Email address" placeholder="john@doe.com"></x-forms.inputs.input-email>
                        </div>

                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-tel name="phone" label="Phone number" placeholder="701897361"></x-forms.inputs.input-tel>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-password name="password" label="Password" placeholder="cattleFarmer1576@!"></x-forms.inputs.input-password>
                        </div>

                        <div class="mt-6 col-12 col-md-6">
                            <x-forms.inputs.input-password name="password_confirmation" id="password-confirm" label="Confirm password" placeholder="cattleFarmer1576@!"></x-forms.inputs.input-password>
                        </div>
                    </div>

                    <div class="mt-6 max-w-sm">
                        <p class="text-xs text-gray-500 leading-5">
                            By clicking Submit, you confirm you have read and agreed to <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="/terms">{{ config('app.name') }} General Terms and Conditions</a> and <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="/privacy">Privacy Policy</a>.
                        </p>
                    </div>

                    <div class="mt-6 block">
                        <x-buttons.button-primary type="submit">
                            Create account <span class="ml-1">&rarr;</span>
                        </x-buttons.button-primary>
                    </div>
                </x-forms.form>
            </div>
        </div>
    </x-sections.section>
@endsection
