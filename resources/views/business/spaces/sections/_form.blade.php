<div class="row">
    <div class="col-12">
        <div>
            <h3 class="leadin-snug">
                {{ isset($space->code) ? 'Edit Space Details' : 'Add New Space' }}
            </h3>

            <div class="flex items-center text-gray-600">
                <p class="text-sm">
                    {{ isset($space->code) ? 'Accurate details help customers.' : 'Get closer to your first sale by adding products.' }}
                </p>
            </div>
        </div>
    </div>
</div>

<hr class="my-8">

@include('business.spaces.sections._basic', ['space' => $space])

<hr class="my-8">

@include('business.spaces.sections._shipping', ['space' => $space])

<hr class="my-8">

<div class="flex items-center justify-end">
    <a href="{{ route('spaces.index') }}" class="btn btn-secondary" type="submit">Cancel</a>

    <button class="btn btn-primary ml-3" type="submit">Save</button>
</div>
