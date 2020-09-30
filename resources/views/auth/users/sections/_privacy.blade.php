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

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.password', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
                @csrf

                @method('PUT')

                <div class="row">
                    <div class="col-md-7 mb-6">
                        <label for="current_password" class="block">
                            <span class="text-sm mb-2 font-semibold">{{ __('Current password') }}</span>

                            <input id="old-password" type="password" class="form-input mt-1 block w-full @error('current_password') is-invalid @enderror" name="current_password" placeholder="">
                        </label>

                        @error('current_password')
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

                <div class="mt-6 py-3 flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
