@extends('layouts.master')

@section('main')
    <section class="relative bg-gray-900 overflow-hidden h-screen">
        <div class="container">
            <div class="relative z-10 pb-8 bg-gray-900 h-screen sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-24">
                    <nav class="relative flex items-center justify-center sm:h-10 lg:justify-start">
                        <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                            <div class="flex items-center justify-center lg:justify-start w-full lg:w-auto">
                                <a href="#">
                                    <img class="h-8 w-auto sm:h-12" src="{{ asset('img/logo-light.png') }}" alt="" />
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="mt-10 mx-auto max-w-screen-xl sm:mt-12 md:mt-16">
                    <div class="text-center lg:text-left">
                        <div class="text-4xl tracking-tight font-semibold text-white sm:text-5xl leading-tight sm:leading-none md:text-6xl">
                            Hold on to your hats!
                            <div class="text-indigo-500">We're opening soon</div>
                        </div>

                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            We're building solutions to deliver peak efficiency and flexibility in your supply chain, backed by dedicated account managers and 24/7 support.
                        </p>

                        <div class="mt-5 sm:mt-8 sm:flex justify-center lg:justify-start">
                            <div class="flex justify-center lg:justify-start">
                                <form class="flex flex-col items-center lg:items-start text-center lg:text-left" action="https://cratespace.us19.list-manage.com/subscribe/post" method="POST">
                                    @csrf

                                    <input type="hidden" name="u" value="37c82dd61bb93e0b473eab52b">

                                    <input type="hidden" name="id" value="9ff337a3ca">

                                    <div class="mb-2">
                                        <span class="font-semibold text-white">Sign up to get notified when it's ready.</span>
                                    </div>

                                    <div class="flex flex-col md:flex-row items-center w-full">
                                        <input type="email" name="b_email" id="b_email" class="form-input w-full md:w-auto block mr-0 mb-3 md:mr-3 md:mb-0" placeholder="Enter your email">

                                        <button class="btn btn-primary leading-tight w-full md:w-auto">Notify me</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <svg class="hidden lg:block absolute right-0 inset-y-0 h-screen w-48 text-gray-900 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
            </div>
        </div>

        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{ asset('img/coming-soon.jpg') }}" alt="" />
        </div>
    </section>
@endsection
