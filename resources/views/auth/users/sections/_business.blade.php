<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Business
            </h4>

            <p class="text-sm max-w-sm">
                This information helps customers recognize your business and understand your terms of service. Your support information may be visible in payment statements, invoices, and receipts.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
                @csrf

                @method('PUT')

                <div class="row items-center">
                    <div class="col-md-4 mb-6 flex items-center">
                        <image-upload-form image="{{ $user->business->image }}" route="/" label="Logo"></image-upload-form>
                    </div>

                    <div class="col-md-8 mb-6">
                        @include('components.forms.fields._business', ['business' => $user->business->name])

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

                <div class="mt-6 py-3 flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
