@extends('layouts.web')

@section('content')
    <section class="py-12 bg-gray-800">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <p class="text-base text-gray-300 font-semibold tracking-wide uppercase">Support</p>

                        <h3 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            How can we help?
                        </h3>

                        <p class="max-w-2xl text-xl text-gray-300 lg:mx-auto">
                            Check out our FAQ section or get 24×7 help from our support staff
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('messages.create', ['support' => 1]) }}" class="btn btn-primary">
                                Contact support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container">
            <div class="row mb-8">
                <div class="col-12">
                    <h4 class="font-semibold text-2xl">Frequently Asked Questions</h4>

                    <hr class="mt-8">
                </div>
            </div>

            <div class="row">
                @for ($i = 0; $i < 7; $i++)
                    <div class="col-lg-6 mb-12 flex flex-col">
                        <div class="flex flex-col flex-1">
                            <h6 class="text-lg font-semibold group-hover:text-indigo-400 mb-6">Why are you calling it "early access"?</h4>

                            <div class="text-gray-600 mt-1">
                                <p class="mb-3">
                                    We're really happy with the components we've put together so far, but we've still got a ton more we're planning to build.
                                </p>

                                <p class="mb-3">
                                    Every component you see in the preview is available to use today, but that's only about 25% of what we have planned.
                                </p>

                                <p class="mb-3">
                                    Instead of waiting until we've completely exhausted our own ideas before releasing the product, we decided to open it up as soon as we had enough to be useful so you can start getting value from it right away.
                                </p>

                                <p class="mb-3">
                                    We'll be adding new components on a regular basis, based on our own ideas and on suggestions from early access customers.
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
