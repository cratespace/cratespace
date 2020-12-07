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
                <sign-up></sign-up>
            </div>
        </div>
    </x-sections.section>
@endsection
