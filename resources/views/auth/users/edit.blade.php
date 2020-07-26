@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4>
                            Profile
                        </h4>

                        <p class="text-sm max-w-sm">
                            This information except your email and phone number will be displayed publicly so be careful what you share.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        <x-cards._full hasFooter="true">
                            @csrf

                            @method('PUT')

                            <div class="mb-8">
                                <image-upload-form image="{{ $user->image }}" route="/" label="Photo"></image-upload-form>
                            </div>

                            <div class="row">
                                <div class="col-md-7 mb-6">
                                    @include('components.forms.fields._name', ['name' => $user->name])
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    @include('components.forms.fields._email', ['email' => $user->email])

                                    <span class="text-sm block mt-2" role="alert">
                                        We will never share your email with anyone else.
                                    </span>
                                </div>

                                <div class="col-md-6 mb-6">
                                    @include('components.forms.fields._username', ['username' => $user->username])
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <div>
                                        @include('components.forms.fields._phone', ['phone' => $user->phone])
                                    </div>
                                </div>
                            </div>

                            <x-slot name="footer">
                                <div class="bg-gray-100 px-4 py-3 sm:px-6 flex items-center justify-end">
                                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                                </div>
                            </x-slot>
                        </x-cards._full>
                    </form>
                </div>
            </div>

            <hr class="my-6">

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4>
                            Privacy
                        </h4>

                        <p class="text-sm max-w-sm">
                            Make sure your passwords meet the minimum requirements to be kept secure and safe.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form action="{{ route('users.password', $user) }}" method="POST" enctype="multipart/form-data">
                        <x-cards._full hasFooter="true">
                            @csrf

                            @method('PUT')

                            <div class="row">
                                <div class="col-md-7 mb-6">
                                    <label for="old_password" class="block">
                                        <span class="text-sm mb-2 font-semibold">{{ __('Current password') }}</span>

                                        <input id="old-password" type="password" class="form-input mt-1 block w-full @error('old_password') is-invalid @enderror" name="old_password" placeholder="">
                                    </label>

                                    @error('old_password')
                                        <span class="text-sm block mt-2 text-red-500" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password" class="block">
                                        <span class="text-sm mb-2 font-semibold">{{ __('New password') }}</span>

                                        <input id="password" type="password" class="form-input mt-1 block w-full @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="">
                                    </label>

                                    @error('password')
                                        <span class="text-sm block mt-2 text-red-500" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="new_password" class="block">
                                        <span class="text-sm mb-2 font-semibold">{{ __('Confirm password') }}</span>

                                        <input id="password-confirm" type="password" class="form-input mt-1 block w-full" name="password_confirmation" autocomplete="new-password" placeholder="">
                                    </label>
                                </div>

                                <div class="col-12">
                                    <span class="text-sm block mt-2" role="alert">
                                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                                    </span>
                                </div>
                            </div>

                            <x-slot name="footer">
                                <div class="bg-gray-100 px-4 py-3 sm:px-6 flex items-center justify-end">
                                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                                </div>
                            </x-slot>
                        </x-cards._full>
                    </form>
                </div>
            </div>

            <hr class="my-6">

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4>
                            Notifications
                        </h4>

                        <p class="text-sm max-w-sm">
                            We'll always let you know about important changes, but you pick what else you want to hear about.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        <x-cards._full hasFooter="true">
                            {{--  --}}

                            <x-slot name="footer">
                                <div class="bg-gray-100 px-4 py-3 sm:px-6 flex items-center justify-end">
                                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                                </div>
                            </x-slot>
                        </x-cards._full>
                    </form>
                </div>
            </div>

            <hr class="my-6">

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4>
                            Security
                        </h4>

                        <p class="text-sm max-w-sm">
                            Take care while you handle these settings. These actions will cause permanent loss of data.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <x-cards._full>
                        <h5 class="text-lg font-medium text-gray-800 mb-3">
                            Delete your account
                        </h5>

                        <p class="text-sm mb-6">
                            Once you delete your account, you will lose all data associated with it.
                        </p>

                        <div>
                            <button class="btn bg-red-200 text-red-800" type="button" data-toggle="modal" data-target="#deleteModal{{ $user->username }}">Delete account</button>
                        </div>
                    </x-cards._full>
                </div>
            </div>
        </div>
    </section>
@endsection
