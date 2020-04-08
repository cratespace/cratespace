@extends('layouts.app.base')

@section('content')
    <section class="pt-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                        Business Settings
                    </h2>

                    <div class="flex items-center text-gray-600">
                        {{ config('app.name') }} and your customers will use this information to contact you.
                    </div>

                    <div class="mt-4">
                        @include('auth.profiles.components._nav', ['user' => $user])
                    </div>

                    <hr class="mt-2 lg:mt-4">
                </div>
            </div>
        </div>
    </section>

    <section class="pt-6 pb-12">
        <div class="container">
            <div class="row mb-6">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold">
                            Basic
                        </h4>

                        <p class="text-sm text-gray-600 max-w-sm">
                            This information helps customers recognize your business and understand your products and terms of service. Your support information may be visible in payment statements, invoices, and receipts.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form class="rounded-lg overflow-hidden shadow" action="{{ route('users.business.information', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-white px-4 py-5 sm:px-6">
                            <div class="row items-center">
                                <div class="col-md-4 mb-6 flex items-center">
                                    <image-upload-form image="{{ $user->business->photo }}" route="{{ route('users.photo', ['type' => 'business']) }}" label="Logo"></image-upload-form>
                                </div>

                                <div class="col-md-8 mb-6">
                                    @include('components.forms.fields._business-name', ['name' => $user->business->name])

                                    <span class="text-xs text-gray-600">Your business name may be used on invoices and receipts. Please make sure it's correct.</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <div>
                                        @include('components.forms.fields._phone', ['phone' => $user->business->phone, 'label' => 'Support phone number'])
                                    </div>
                                </div>

                                <div class="col-md-6 mb-6">
                                    @include('components.forms.fields._email', ['email' => $user->business->email, 'label' => 'Support email'])
                                </div>
                            </div>

                            <div>
                                @include('components.forms.fields._description', ['description' => $user->business->description])
                            </div>
                        </div>

                        <div class="bg-gray-100 px-4 py-5 sm:px-6">
                            <div class="flex items-center justify-end">
                                <button class="btn btn-primary ml-3" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold">
                            Address
                        </h4>

                        <p class="text-sm text-gray-600 max-w-sm">
                            This address will appear on your invoices. This information will be used to show where your business is based in and where it primarily operates.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form class="rounded-lg overflow-hidden shadow" action="{{ route('users.business.address', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-white px-4 py-5 sm:px-6">
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    @include('components.forms.fields._country', ['country' => $user->business->country])
                                </div>
                            </div>

                            <div class="mb-6">
                                @include('components.forms.fields._street', ['street' => $user->business->street])
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-6 md:mb-0">
                                    @include('components.forms.fields._city', ['city' => $user->business->city])
                                </div>

                                <div class="col-md-4 mb-6 md:mb-0">
                                    @include('components.forms.fields._state', ['state' => $user->business->state])
                                </div>

                                <div class="col-md-4">
                                    @include('components.forms.fields._postcode', ['postcode' => $user->business->postcode])
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-4 py-5 sm:px-6">
                            <div class="flex items-center justify-end">
                                <button class="btn btn-primary ml-3" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
