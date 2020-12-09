@extends('layouts.auth')

@section('content')
    <x-sections.section>
        <div class="col-xl-4 col-lg-5 col-md-8">
            <div>
                <x-logos.logo class="h-16 w-16"></x-logos.logo>
            </div>

            <div class="mt-6">
                <x-titles.h2>Confirm sign in</x-titles.h2>

                <x-titles.h6>Don't have an account yet? <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="{{ route('signup') }}">Sign up</a></x-titles.h6>
            </div>

            <div>
                <tfa-challenge></tfa-challenge>
            </div>
        </div>
    </x-sections.section>
@endsection
