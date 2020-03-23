@extends('layouts.master')

@section('main')
    <!-- Content -->
    <section class="relative bg-gray-800 overflow-hidden">
        <div class="container">
            <div class="relative z-10 pb-8 bg-gray-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-6">
                    <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start">
                        <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                            <div class="flex items-center justify-between w-full md:w-auto">
                                <a href="#">
                                    <img class="h-8 w-auto sm:h-10" src="{{ asset('img/logo.png') }}" alt="" />
                                </a>

                                <button class="navbar-toggler inline-flex md:hidden items-center justify-center text-gray-300 hover:text-white focus:outline-none focus:text-gray-400" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="hidden md:block md:ml-10 md:pr-4">
                            @include('layouts.partials.nav.links._public')
                        </div>
                    </nav>

                    <div class="collapse block md:hidden" id="navbarToggleExternalContent">
                        <div class="py-5 flex flex-col justify-center border-b border-gray-700">
                            @include('layouts.partials.nav.links._public')
                        </div>
                    </div>
                </div>

                <div class="mt-10 mx-auto max-w-screen-xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-32">
                    <div class="sm:text-center lg:text-left">
                        <div class="text-4xl tracking-tight font-semibold text-white sm:text-5xl sm:leading-none md:text-6xl">
                            <div>Best place for</div>
                            <span class="text-indigo-500">logistics businesses</span>
                        </div>

                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            We're building solutions to deliver peak efficiency and flexibility in your supply chain, backed by dedicated account managers and 24/7 support.
                        </p>

                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-lg shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Get started
                                </a>
                            </div>

                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('messages.create') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-500 bg-white hover:text-indigo-500 hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:border-indigo-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Contact us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-gray-800 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
            </div>
        </div>

        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{ asset('img/hero.jpg') }}" alt="" />
        </div>
    </section>

    <section class="relative py-20 bg-gray-100 overflow-hidden">
        <svg class="hidden lg:block absolute right-0 top-0 transform translate-x-1/2 -translate-y-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784">
            <defs>
                <pattern id="svg-pattern-squares-1" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-300" fill="currentColor"></rect>
                </pattern>
            </defs>

            <rect width="404" height="784" fill="url(#svg-pattern-squares-1)"></rect>
        </svg>

        <svg class="hidden lg:block absolute left-0 bottom-0 transform -translate-x-1/2 translate-y-1/2 " width="404" height="784" fill="none" viewBox="0 0 404 784">
            <defs>
                <pattern id="svg-pattern-squares-3" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-gray-300" fill="currentColor"></rect>
                </pattern>
            </defs>

            <rect width="404" height="784" fill="url(#svg-pattern-squares-3)"></rect>
        </svg>

        <div class="container">
            <div class="row mb-20">
                <div class="col-12">
                    <div class="relative">
                        <h3 class="text-center text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl">
                            A better way to do logistics
                        </h3>

                        <p class="mt-4 max-w-xl mx-auto text-center text-xl text-gray-600">
                            Whether you want to stay local or drive over the road, finding the right load has never been easier.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mb-20">
                <div class="col-lg-6">
                    <div class="relative">
                        <h4 class="text-2xl font-extrabold text-gray-800 tracking-tight sm:text-3xl">
                            Maximize your payload
                        </h4>

                        <p class="mt-3 text-lg text-gray-600">
                            {{ config('app.name') }} is helping give control to carriers with customized load suggestions, free quick pay, and automatic reload options. It's the one app for every haul.
                        </p>

                        <ul class="mt-10">
                            <li>
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <h5 class="text-lg font-medium text-gray-800">Transparency</h5>

                                        <p class="mt-2 text-base text-gray-600">
                                            With clear, upfront pricing and unrivaled visibility, you always have the information needed to make the right business decisions.
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-10">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <h5 class="text-lg font-medium text-gray-800">Freight at your fingertips</h5>

                                        <p class="mt-2 text-base text-gray-600">
                                            Our streamlined workflow and 24/7 support keeps your business rolling, quickly and efficiently.
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-10">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <h5 class="text-lg font-medium text-gray-800">Advanced technologies</h5>

                                        <p class="mt-2 text-base text-gray-600">
                                            Our technology has revolutionized the way people move. Now we’re doing the same for the freight industry.
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="lg:col-start-2">
                        <h4 class="text-2xl font-extrabold text-gray-800 tracking-tight sm:text-3xl">
                            Always in the loop
                        </h4>

                        <p class="mt-3 text-lg text-gray-600">
                            It’s time to put an end to all the phone calls and faxing. Take control of your business with an app that makes booking and managing loads easier than ever.
                        </p>

                        <ul class="mt-10">
                            <li>
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <h5 class="text-lg font-medium text-gray-800">Mobile notifications</h5>

                                        <p class="mt-2 text-base text-gray-600">
                                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-10">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <h5 class="text-lg font-medium text-gray-800">Reminder emails</h5>

                                        <p class="mt-2 text-base text-gray-600">
                                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-indigo-900">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="md:flex md:flex-col pr-0 lg:pr-12 mb-20 lg:mb-0">
                        <div class="md:flex-shrink-0">
                            <svg fill="none" height="40" viewBox="0 0 105 40">
                                <path fill="#B4C6FC" fill-rule="evenodd" d="M18 1L0 7v19.5l6 2V34l18 6V8.5l-6 2V1zM8 29.167L18 32.5V12.608l4-1.333v25.95L8 32.558v-3.391z" clip-rule="evenodd"></path>
                                <path fill="#B4C6FC" d="M42.9 28V17.45h-3.51v-3.392h11.486v3.393h-3.53V28H42.9zM59.481 28.254c-4.075 0-6.376-2.028-6.376-6.006v-8.19h4.407v8.014c0 1.814.39 2.71 1.97 2.71 1.56 0 1.95-.896 1.95-2.73v-7.994h4.445v8.15c0 4.193-2.496 6.046-6.396 6.046z"></path>
                                <path fill="#B4C6FC" fill-rule="evenodd" d="M68.965 14.058V28h4.407v-4.543h1.346c3.607 0 5.538-1.638 5.538-4.544v-.078c0-2.983-1.716-4.777-5.733-4.777h-5.558zm4.407 6.435h.916c1.17 0 1.775-.527 1.775-1.56v-.078c0-1.073-.605-1.502-1.755-1.502h-.936v3.14z" clip-rule="evenodd"></path>
                                <path fill="#B4C6FC" d="M82.563 14.058V28h9.497v-3.412h-5.07v-10.53h-4.427zM94.562 28V14.058h9.906v3.393h-5.499v1.97h4.368v3.1h-4.368v2.086h5.811V28H94.562z"></path>
                            </svg>
                        </div>

                        <blockquote class="mt-8 md:flex-grow md:flex md:flex-col">
                            <div class="relative text-lg leading-7 font-medium text-white md:flex-grow">
                                <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                </svg>

                            <p class="relative">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.
                            </p>
                            </div>

                            <div class="mt-8">
                                <div class="flex">
                                    <div class="flex-shrink-0 inline-flex rounded-full border-2 border-white">
                                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                                    </div>

                                    <div class="ml-4">
                                        <div class="text-base leading-6 font-medium text-white">Judith Black</div>
                                        <div class="text-base leading-6 font-medium text-indigo-200">CEO, Tuple</div>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="md:flex md:flex-col pl-0 lg:pl-12">
                        <div class="md:flex-shrink-0">
                            <svg fill="none" height="40" viewBox="0 0 105 40">
                                <path fill="#B4C6FC" fill-rule="evenodd" d="M18 1L0 7v19.5l6 2V34l18 6V8.5l-6 2V1zM8 29.167L18 32.5V12.608l4-1.333v25.95L8 32.558v-3.391z" clip-rule="evenodd"></path>
                                <path fill="#B4C6FC" d="M42.9 28V17.45h-3.51v-3.392h11.486v3.393h-3.53V28H42.9zM59.481 28.254c-4.075 0-6.376-2.028-6.376-6.006v-8.19h4.407v8.014c0 1.814.39 2.71 1.97 2.71 1.56 0 1.95-.896 1.95-2.73v-7.994h4.445v8.15c0 4.193-2.496 6.046-6.396 6.046z"></path>
                                <path fill="#B4C6FC" fill-rule="evenodd" d="M68.965 14.058V28h4.407v-4.543h1.346c3.607 0 5.538-1.638 5.538-4.544v-.078c0-2.983-1.716-4.777-5.733-4.777h-5.558zm4.407 6.435h.916c1.17 0 1.775-.527 1.775-1.56v-.078c0-1.073-.605-1.502-1.755-1.502h-.936v3.14z" clip-rule="evenodd"></path>
                                <path fill="#B4C6FC" d="M82.563 14.058V28h9.497v-3.412h-5.07v-10.53h-4.427zM94.562 28V14.058h9.906v3.393h-5.499v1.97h4.368v3.1h-4.368v2.086h5.811V28H94.562z"></path>
                            </svg>
                        </div>

                        <blockquote class="mt-8 md:flex-grow md:flex md:flex-col">
                            <div class="relative text-lg leading-7 font-medium text-white md:flex-grow">
                                <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                </svg>

                            <p class="relative">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita voluptas culpa sapiente alias molestiae. Numquam corrupti in laborum sed rerum et corporis.
                            </p>
                            </div>

                            <div class="mt-8">
                                <div class="flex">
                                    <div class="flex-shrink-0 inline-flex rounded-full border-2 border-white">
                                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                                    </div>

                                    <div class="ml-4">
                                        <div class="text-base leading-6 font-medium text-white">Judith Black</div>
                                        <div class="text-base leading-6 font-medium text-indigo-200">CEO, Tuple</div>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-800">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="max-w-4xl mx-auto text-center">
                        <h2 class="text-3xl leading-9 font-extrabold text-white sm:text-4xl sm:leading-10">
                            Trusted by companies from over 80 countries
                        </h2>

                        <p class="mt-3 text-xl leading-7 text-gray-300 sm:mt-4">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus repellat laudantium.
                        </p>
                    </div>

                    <div class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                        <div>
                            <p class="text-5xl leading-none font-extrabold text-white">
                                100%
                            </p>

                            <p class="mt-2 text-lg leading-6 font-medium text-gray-300">
                                Pepperoni
                            </p>
                        </div>

                        <div class="mt-10 sm:mt-0">
                            <p class="text-5xl leading-none font-extrabold text-white">
                                24/7
                            </p>

                            <p class="mt-2 text-lg leading-6 font-medium text-gray-300">
                                Delivery
                            </p>
                        </div>

                        <div class="mt-10 sm:mt-0">
                            <p class="text-5xl leading-none font-extrabold text-white">
                                100k+
                            </p>

                            <p class="mt-2 text-lg leading-6 font-medium text-gray-300">
                                Calories
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl leading-tight">
                        <div>Ready to get started?</div>
                        <div class="text-indigo-600">Get in touch or create an account.</div>
                    </div>

                    <div class="mt-8 flex">
                        <div class="inline-flex rounded-lg shadow">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                Get started
                            </a>
                        </div>

                        <div class="ml-3 inline-flex">
                            <a href="{{ route('messages.create') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:border-indigo-300 transition duration-150 ease-in-out">
                                Learn more
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('layouts.partials._footer')
@endsection
