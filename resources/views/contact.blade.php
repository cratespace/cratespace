@extends('layouts.web.base')

@section('content')
    <section class="pt-12 pb-24">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-6 lg:mb-0">
                    <div class="max-w-lg mb-12">
                        <h3 class="text-2xl sm:text-3xl font-semibold text-gray-800 leading-tight">
                            Get in touch with our sales team
                        </h3>

                        <p class="mt-2 text-lg text-gray-600">
                            We'd love to hear from you. Our team is happy to answer your sales questions.
                            Fill out the form opposite or email us, and we’ll be in touch as soon as possible.
                        </p>
                    </div>

                    <div class="max-w-md mt-6">
                        <h4 class="text-xl font-semibold text-gray-800 leading-tight">General communication</h4>

                        <p class="mt-2 text-base leading-6 text-gray-600">
                            For general queries, including partnership opportunities, please email <a class="text-indigo-500 hover:text-indigo-400" href="mailto:info@cratespace.io">info@cratespace.io</a>.
                        </p>
                    </div>

                    <div class="max-w-md mt-10">
                        <h4 class="text-xl font-semibold text-gray-800 leading-tight">Technical or account support</h4>

                        <p class="mt-2 text-base leading-6 text-gray-600">
                            We’re here to help! If you have technical issues, <a class="text-indigo-500 hover:text-indigo-400" href="mailto:support@cratespace.io">support@cratespace.io</a>.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 mb-6 lg:mb-0">
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
                                <button class="btn btn-primary w-full">Let's talk</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-12 pb-16">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="text-2xl font-semibold text-gray-800 leading-tight">Get in touch</h4>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <div class="font-semibold mb-2 text-lg text-gray-800">Collaborate</div>

                            <a href="mailto:business@cratespace.biz">business@cratespace.biz</a>

                            <div class="text-gray-600">+94 (77) 501-8795</div>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-semibold mb-2 text-lg text-gray-800">Press</div>

                            <a href="mailto:business@cratespace.biz">press@cratespace.biz</a>

                            <div class="text-gray-600">+94 (77) 501-8795</div>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-semibold mb-2 text-lg text-gray-800">Join our team</div>

                            <a href="mailto:business@cratespace.biz">careers@cratespace.biz</a>

                            <div class="text-gray-600">+94 (77) 501-8795</div>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-semibold mb-2 text-lg text-gray-800">Say hello</div>

                            <a href="mailto:business@cratespace.biz">hello@cratespace.biz</a>

                            <div class="text-gray-600">+94 (77) 501-8795</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="mt-10 mb-20">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <h4 class="text-2xl font-semibold text-gray-800 leading-tight">Locations</h4>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <div class="font-medium mb-2 text-lg text-gray-800">Los Angeles</div>

                            <p class="text-gray-600">
                                123 Duke Street West<br>
                                Santa Monica, LA NY6 4H8
                            </p>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-medium mb-2 text-lg text-gray-800">Los Angeles</div>

                            <p class="text-gray-600">
                                123 Duke Street West<br>
                                Santa Monica, LA NY6 4H8
                            </p>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-medium mb-2 text-lg text-gray-800">Los Angeles</div>

                            <p class="text-gray-600">
                                123 Duke Street West<br>
                                Santa Monica, LA NY6 4H8
                            </p>
                        </div>

                        <div class="col-md-6 mb-10">
                            <div class="font-medium mb-2 text-lg text-gray-800">Los Angeles</div>

                            <p class="text-gray-600">
                                123 Duke Street West<br>
                                Santa Monica, LA NY6 4H8
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
