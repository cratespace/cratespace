<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Address
            </h4>

            <p class="text-sm max-w-sm">
                This address will appear on your invoices. This information will be used to show where your business is based in and where it primarily operates.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
                @csrf

                @method('PUT')

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

                <div class="mt-6 py-3 flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
