@extends('layouts.web')

@section('content')
    @if (session()->has('message'))
        <section class="py-12 bg-gray-800">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="lg:text-center">
                            <p class="text-base text-gray-300 font-semibold tracking-wide uppercase">Thank you</p>

                            <h3 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                It's great to be connected
                            </h3>

                            <p class="max-w-2xl text-xl text-gray-300 lg:mx-auto">
                                Thanks again for your message. <br />
                                Our sales team will get back to you ASAP!
                            </p>

                            <div class="mt-10">
                                <a href="{{ route('spaces') }}" class="btn transition duration-150 ease-in-out text-base mr-4">
                                    Browse spaces
                                </a>

                                <a href="{{ route('welcome') }}" class="btn bg-white text-indigo-900 hover:bg-indigo-100 hover:text-indigo-900 transition duration-150 ease-in-out text-base">
                                    Go back home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="pt-12 bg-gray-800" style="padding-bottom: 22rem;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="lg:text-center">
                            <p class="text-base text-gray-300 font-semibold tracking-wide uppercase">Contact</p>

                            <h3 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                Get in touch with our {{ request()->has('support') ? 'support' : 'sales' }} team
                            </h3>

                            <p class="max-w-2xl text-xl text-gray-300 lg:mx-auto">
                                Our team is happy to answer your sales/support questions.
                                Fill out the form and we’ll be in touch as soon as possible.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-gray-200">
            <div class="container" style="margin-top: -22rem;">
                <div class="row justify-center">
                    <div class="col-lg-8">
                        <div class="rounded-lg overflow-hidden shadow-lg">
                            <div class="bg-white px-4 py-5 sm:px-6">
                                <form action="{{ route('messages.store') }}" method="POST">
                                    <div class="mb-6">
                                        @include('components.forms.fields._name')
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            @include('components.forms.fields._phone')
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            @include('components.forms.fields._email')
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        @include('components.forms.fields._subject')
                                    </div>

                                    <div class="mb-6">
                                        @include('components.forms.fields._message')
                                    </div>

                                    <div>
                                        <div class="flex justify-end items-center">
                                            <button class="btn btn-primary">Send message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-16 mb-4">
                            <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
                                <li>
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="ml-4">
                                            <h5 class="text-lg leading-6 font-medium text-gray-800">General communication</h5>

                                            <p class="mt-2 text-base leading-6 text-gray-500">
                                                For general queries, including partnership opportunities, please email <a class="text-indigo-500 hover:text-indigo-400" href="mailto:info@cratespace.io">info@cratespace.io</a>.
                                            </p>
                                        </div>
                                    </div>
                                </li>

                                <li class="mt-10 md:mt-0">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="ml-4">
                                            <h5 class="text-lg leading-6 font-medium text-gray-800">Technical or account support</h5>
                                            <p class="mt-2 text-base leading-6 text-gray-500">
                                                We’re here to help! If you have technical issues, <a class="text-indigo-500 hover:text-indigo-400" href="mailto:support@cratespace.io">support@cratespace.io</a>.
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
