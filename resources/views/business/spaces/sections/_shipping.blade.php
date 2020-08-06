<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Shipping
            </h4>

            <p class="text-sm max-w-sm">
                Please be warned that you are responsible for the accuracy of this information. Make sure to be specific when mentioning origin and destination locations.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <div>
            <div class="row">
                <div class="col-lg-8 mb-6">
                    @include('components.forms.fields._types', ['editableType' => $space->type])

                    <span class="text-sm block mt-2 text-gray-500" role="alert">
                        Where the space is being transported within. Ex. from origin country to a foreign country or within the origin country itself.
                    </span>
                </div>
            </div>

            <div class="mb-6">
                @include('components.forms.fields._base', ['base' => $space->base])
            </div>

            <div class="row">
                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._origin', ['origin' => $space->origin])
                </div>

                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._destination', ['destination' => $space->destination])
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._departs-at', ['departs_at' => $space->departs_at])
                </div>

                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._arrives-at', ['arrives_at' => $space->arrives_at])
                </div>
            </div>

            <div>
                @include('components.forms.fields._note', ['note' => $space->note])
            </div>

            <input type="hidden" name="base" value="{{ user('business')->country }}">
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datetime').flatpickr({
                dateFormat: 'Y-m-d H:i',
                altInput: true,
                altFormat: 'j M Y, h:i K',
                ariaDateFormat: 'Y-m-d H:i',
                enableTime: true,
                minDate: Date.now()
            });
        });
    </script>
@endpush
