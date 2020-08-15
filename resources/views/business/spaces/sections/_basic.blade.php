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
            <div class="row mb-6">
                <div class="col-lg-7 mb-6 lg:mb-0">
                    @include('components.forms.fields._uid', ['uid' => $space->code])
                </div>

                <div class="col-lg-5">
                    @include('components.forms.fields._weight', ['weight' => $space->weight])
                </div>
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
                <div class="col-lg-6 mb-6 lg:mb-0">
                    @include('components.forms.fields._price', ['price' => $space->price / 100])

                    <span class="text-sm block mt-2 text-gray-500" role="alert">
                        The price should be exclusive of all taxes and in <span class="font-semibold">USD</span> currency format.
                    </span>
                </div>

                <div class="col-lg-6 mb-6 lg:mb-0">
                    @include('components.forms.fields._tax', ['tax' => $space->tax / 100])

                    <span class="text-sm block mt-2 text-gray-500" role="alert">
                        Tax should be a calculated amount of the price provided.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
