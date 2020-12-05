@extends('layouts.auth')

@section('content')
    <x-sections.section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <x-logos.logo class="h-16 w-16"></x-logos.logo>
            </div>

            <div class="mt-6">
                <x-titles.h2>Welcome back</x-titles.h2>

                <x-titles.h6>Sign in to your account</x-titles.h6>
            </div>

            <div>
                <x-forms.form action="{{ route('signin') }}" method="POST" class="w-full">
                    <div class="mt-6 block">
                        <x-forms.inputs.input-email name="email" label="Email address" placeholder="john@doe.com"></x-forms.inputs.input-email>
                    </div>

                    <div class="mt-6 block">
                        <x-forms.inputs.input-password name="password" label="Password" placeholder="cattleFarmer1576@!"></x-forms.inputs.input-password>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <x-forms.inputs.input-checkbox checked name="remember" label="Stay signed in"></x-forms.inputs.input-checkbox>

                        <div class="text-sm leading-5">
                            <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 block">
                        <x-buttons.button-primary type="submit">
                            Sign in <span class="ml-1">&rarr;</span>
                        </x-buttons.button-primary>
                    </div>
                </x-forms.form>
            </div>

            <div class="mt-6">
                <span class="text-sm text-gray-600">
                    Don't have an account yet? <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('signup') }}">Sign up</a>
                </span>
            </div>
        </div>
    </x-sections.section>
@endsection
