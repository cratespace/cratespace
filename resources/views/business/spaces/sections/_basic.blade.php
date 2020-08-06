<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Basic
            </h4>

            <p class="text-sm max-w-sm">
                The customer needs to get a basic understanding of the space you have available, to see if it suits there needs.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <div>
            <div class="mb-6">
                @include('components.forms.fields._uid', ['uid' => $space->uid])

                <span class="text-sm block mt-2 text-gray-500" role="alert">
                    Code must be unique.
                </span>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._height', ['height' => $space->height])
                </div>

                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._width', ['width' => $space->width])
                </div>

                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._length', ['length' => $space->length])
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._price', ['price' => $space->price()])

                    <span class="text-sm block mt-2 text-gray-500" role="alert">
                        The price should be exclusive of all taxes.
                    </span>
                </div>

                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._tax', ['tax' => $space->tax()])

                    <span class="text-sm block mt-2 text-gray-500" role="alert">
                        All taxes should be totaled here.
                    </span>
                </div>

                <div class="col-lg-4 mb-6">
                    @include('components.forms.fields._weight', ['weight' => $space->weight])
                </div>
            </div>
        </div>
    </div>
</div>
