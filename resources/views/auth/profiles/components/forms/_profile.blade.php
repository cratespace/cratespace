<div class="row mb-6">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4 class="text-xl font-semibold">
                Profile
            </h4>

            <p class="text-sm text-gray-600 max-w-sm">
                This information except your email and phone number will be displayed publicly so be careful what you share.
            </p>
        </div>
    </div>

    <div class="col-lg-8">
        <form class="rounded-lg overflow-hidden shadow" action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white px-4 py-5 sm:px-6">
                <div class="mb-8">
                    <image-upload-form image="{{ $user->photo }}" route="{{ route('users.photo') }}" label="Photo"></image-upload-form>
                </div>

                <div class="mb-6">
                    @include('components.forms.fields._name', ['name' => $user->name])
                </div>

                <div class="row">
                    <div class="col-md-6 mb-6">
                        @include('components.forms.fields._email', ['email' => $user->email])

                        <span class="text-sm block mt-2 text-gray-500" role="alert">
                            We'll never share your email with anyone else.
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
            </div>

            <div class="bg-gray-100 px-4 py-5 sm:px-6">
                <div class="flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
