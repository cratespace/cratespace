@extends('layouts.auth.base')

@section('content')
    <section class="relative flex flex-col justify-center items-center bg-auth bg-contain bg-no-repeat min-h-screen bg-right-top">
        <div class="container items-center justify-center">
            <div class="row justify-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="fixed inset-0 md:relative p-6 sm:p-20 xl:px-12 lg:px-10 md:px-8 xl:py-10 lg:py-8 md:py-6 bg-white md:rounded-lg md:shadow-lg flex flex-col justify-center">
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="block h-16 w-16 mx-auto">
                                <img class="h-16 w-16" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" />
                            </a>

                            <h2 class="mt-2">
                                Welcome back
                            </h2>

                            <h6 class="text-gray-600">
                                Sign in to your account
                            </h6>
                        </div>

                        <form class="mt-4" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div>
                                @include('components.forms.fields._email')
                            </div>

                            <div class="mt-4">
                                @include('components.forms.fields._current-password')
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                @include('components.forms.fields._remember')

                                <div class="text-sm leading-5">
                                    <a href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full btn btn-primary">
                                    Sign in <span class="ml-1">&rarr;</span>
                                </button>
                            </div>

                            <div class="mt-6 text-center">
                                <span class="text-sm text-gray-600">
                                    Don't have an account yet? <a href="{{ route('register') }}">Sign up</a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
