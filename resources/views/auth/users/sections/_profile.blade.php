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

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
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

                <div class="mt-6 py-3 flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
