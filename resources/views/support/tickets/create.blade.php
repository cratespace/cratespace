@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row">
                <div class="mb-10 col-md-7">
                    <div>
                        <h3 class="leadin-snug">
                            Contact support
                        </h3>

                        <div class="mt-6">
                            <form action="{{ route('tickets.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-8 mb-6">
                                        @include('components.forms.fields._name', ['name' => optional(user())->name])
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-6">
                                        @include('components.forms.fields._phone', ['phone' => optional(user())->phone])
                                    </div>

                                    <div class="col-lg-6 mb-6">
                                        @include('components.forms.fields._email', ['email' => optional(user())->email])
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <label class="block">
                                        <span class="text-gray-700 text-sm font-semibold">What do you need help with?</span>

                                        <input name="subject" id="subject" type="text" class="form-input mt-1 block w-full @error('subject') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('subject') ?? ($subject ?? null) }}" placeholder="Purchasing Space">
                                    </label>

                                    @error('subject')
                                        <div class="mt-2" role="alert">
                                            <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-8">
                                    <div>
                                        <span class="text-gray-700 text-sm font-semibold">Before you email, do these answer your question?</span>
                                    </div>

                                    <div class="mt-4">
                                        <div class="mb-4">
                                            <a href="#" class="block">
                                                <h6 class="text-sm">Cras mattis consectetur purus sit amet fermentum</h6>
                                            </a>

                                            <p class="text-sm mt-1">
                                                Donec id elit non mi porta gravida at eget metus. Cras justo odio...
                                            </p>
                                        </div>

                                        <div class="mb-4">
                                            <a href="#" class="block">
                                                <h6 class="text-sm">Maecenas faucibus mollis interdum</h6>
                                            </a>

                                            <p class="text-sm mt-1">
                                                Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Duis mollis...
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <label class="block">
                                        <span class="text-gray-700 text-sm font-semibold">{{ __('Tell us more—how can we help?') }}</span>

                                        <textarea name="description" id="description" rows="5" placeholder="Tell us a little about your business" class="form-input block w-full mt-1 @error('description') is-invalid @enderror">{{ old('description') ?? ($description ?? null) }}</textarea>
                                    </label>

                                    @error('description')
                                        <span class="text-sm block mt-2 text-red-500" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="btn btn-secondary inline-flex leading-8 px-3 cursor-pointer">
                                        <span class="inline-flex items-center">
                                            <span class="text-base">&uarr;</span> <span class="ml-2 text-gray-700 text-xs font-semibold">{{ __('Upload a file') }}</span>
                                        </span>

                                        <input type="file" class="hidden inline-block" name="attachement" id="attachement">
                                    </label>
                                </div>

                                <hr class="my-8">

                                <div>
                                    <button class="btn btn-primary">Submit ticket</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mb-10 col-md-4 offset-md-1 col-lg-3 offset-lg-2">
                    @include('support.partials._sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
