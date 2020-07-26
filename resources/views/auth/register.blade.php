@extends('layouts.auth.base')

@section('content')
<section class="relative bg-white min-h-screen">
    <div class="row no-gutters">
        <div class="col-lg-5 hidden lg:block min-h-screen bg-auth bg-cover bg-no-repeat bg-right-top">
            <div class="flex flex-col items-end py-24 pr-16">
                <div>
                    <a href="{{ url('/') }}" class="block mb-8">
                        <img class="h-8 w-auto" src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" />
                    </a>

                    <div class="mb-4 flex">
                        <div class="mr-2 mt-1">
                            <svg class="h-5 w-5 fill-current text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div>
                            <div class="font-semibold text-gray-800">Quick and free sign‑up</div>

                            <p class="w-64 text-sm">Enter your email address to create an account.</p>
                        </div>
                    </div>

                    <div class="mb-4 flex">
                        <div class="mr-2 mt-1">
                            <svg class="h-5 w-5 fill-current text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div>
                            <div class="font-semibold text-gray-800">Simple data entry</div>

                            <p class="w-64 text-sm">Use Cratespace's dashaboard to upload space information.</p>
                        </div>
                    </div>

                    <div class="mb-4 flex">
                        <div class="mr-2 mt-1">
                            <svg class="h-5 w-5 fill-current text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div>
                            <div class="font-semibold text-gray-800">Start accepting orders</div>

                            <p class="w-64 text-sm">Job done! Your live in minutes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 min-h-screen border-l border-gray-300">
            <div class="h-full flex flex-col items-center justify-center p-12 xl:p-0">
                <div>
                    <div>
                        <a href="{{ url('/') }}" class="block lg:hidden mb-2">
                            <img class="h-8 w-auto" src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" />
                        </a>

                        <h2 class="mt-2">
                            Let's get you started
                        </h2>

                        <h6 class="text-gray-600">
                            Already have an account? <a href="{{ route('login') }}">Sign in</a>
                        </h6>
                    </div>

                    <form class="mt-4" action="{{ route('register') }}" method="POST">
                        @csrf

                        <input type="hidden" name="type" value="company">

                        <div>
                            @include('components.forms.fields._name')
                        </div>

                        <div class="mt-4">
                            @include('components.forms.fields._business')
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                @include('components.forms.fields._phone')
                            </div>

                            <div class="col-md-6 mb-4">
                                @include('components.forms.fields._email')

                                <span class="text-xs text-gray-600">Make sure this is the business email.</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                @include('components.forms.fields._new-password')
                            </div>

                            <div class="col-md-6">
                                @include('components.forms.fields._confirm-password')
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-xs text-gray-600 max-w-sm">
                                By clicking Submit, you confirm you have read and agreed to <a href="/terms">{{ config('app.name') }} General Terms and Conditions</a> and <a href="/privacy">Privacy Policy</a>.
                            </p>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary w-full">
                                Create your {{ config('app.name') }} account <span class="ml-1">&rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
