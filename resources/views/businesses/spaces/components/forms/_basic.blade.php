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
    <div class="col-lg-7 mb-6 lg:mb-0">
        @include('components.forms.fields._price', ['price' => $space->price])

        <span class="text-sm block mt-2 text-gray-500" role="alert">
            The price should be inclusive of all necessary taxes.
        </span>
    </div>

    <div class="col-lg-5">
        @include('components.forms.fields._weight', ['weight' => $space->weight])
    </div>
</div>
