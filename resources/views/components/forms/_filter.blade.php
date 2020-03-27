<form class="shadow-lg rounded-lg" action="{{ route('listings', ['category' => request('category')->slug ?? null]) }}" method="GET">
    <div class="bg-white px-4 py-5 sm:px-6 rounded-t-lg">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-6 lg:mb-0">
                <label class="block">
                    <span class="text-gray-700 text-sm font-semibold">Origin</span>

                    <select required name="origin" id="origin" class="form-select mt-1 block w-full">
                        <option value="">All cities</option>

                        @foreach ($filters['origins'] as $origin)
                            <option @if (request('origin') == $origin) selected @endif value="{{ $origin }}">{{ $origin }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="col-lg-3 col-md-6 mb-6 lg:mb-0">
                <label class="block">
                    <span class="text-gray-700 text-sm font-semibold">Destination</span>

                    <select required name="destination" id="destination" class="form-select mt-1 block w-full">
                        <option value="">All cities</option>

                        @foreach ($filters['destinations'] as $destination)
                            <option @if (request('destination') == $destination) selected @endif value="{{ $destination }}">{{ $destination }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="col-lg-3 col-md-6 mb-6 lg:mb-0">
                @include('components.forms.fields._departs-at', [
                    'departsAt' => request('departsAt') ?: null
                ])
            </div>

            <div class="col-lg-3 col-md-6 mb-6 lg:mb-0">
                @include('components.forms.fields._arrives-at', [
                    'arrivesAt' => request('arrivesAt') ?: null
                ])
            </div>
        </div>
    </div>

    <div class="bg-gray-100 px-4 py-5 sm:px-6 rounded-b-lg">
        <div class="row">
            <div class="col-12">
                <div class="flex items-center justify-between">
                    <div class="dropdown">
                        <button class="btn btn-secondary flex items-center" id="categoryDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>{{ request('type') ?? 'All' }} shipping</span>

                            <svg class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <div class="dropdown-menu rounded-lg shadow-lg z-50 mt-3" aria-labelledby="categoryDropDown">
                            <a href="{{ route('listings') }}" class="dropdown-item block px-4 py-2 text-sm">All</a>

                            @foreach (config('shipping.types') as $type)
                                <a href="{{ route('listings', ['type' => $type]) }}" class="dropdown-item block px-4 py-2 text-sm">{{ $type }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center">
                        @if (request()->query())
                            <a class="text-sm btn btn-secondary py-2 px-3" href="{{ route('listings') }}">
                                <span>Clear filters</span>
                            </a>
                        @endif

                        <button class="btn btn-primary flex items-center ml-2" type="submit">
                            <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>

                            Search spaces
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datetime').flatpickr({
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j M Y',
                ariaDateFormat: 'Y-m-d',
                enableTime: false
            });
        });
    </script>
@endpush
