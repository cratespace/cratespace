<section class="pt-32 pb-20 -mt-20 min-h-height bg-cover bg-no-repeat bg-center" style="background-image: url({{ asset('img/bg-landing.svg') }});">
    <div class="container">
        <div class="row justify-center">
            <div class="col-lg-6 flex flex-col mb-6 lg:mb-0">
                <div class="flex flex-col flex-1 justify-center text-center lg:text-left">
                    <div>
                        <h1 class="text-3xl lg:text-4xl leading-10 font-bold">
                            Find the best deals <br>
                            on shipping right now
                        </h1>

                        <p class="mt-2 lg:mt-4 text-base lg:text-lg mx-auto lg:mx-0 max-w-md">
                            Whether you want to stay local or drive over the road, finding the right load has never been easier.
                        </p>

                        <div class="mt-6 flex items-center justify-center lg:justify-start">
                            <a class="btn btn-secondary" href="#">{{ __('Learn more') }}</a>

                            <a class="ml-4 text-sm font-medium text-white lg:text-blue-500" href="/">{{ __('Contact sales') }} <span class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 flex md:flex-col">
                <form action="/" method="GET" class="overflow-hidden rounded-lg shadow-2xl w-full">
                    <div class="bg-white px-4 pt-5 pb-8 sm:px-6">
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5" name="type" id="type" value="all" @if (! request()->has('type') || request('type') === 'all') checked="checked" @endif>

                                <span class="ml-2 text-gray-700 text-sm font-semibold">{{ __('All') }}</span>
                            </label>

                            <label class="inline-flex items-center cursor-pointer ml-6">
                                <input type="radio" class="form-radio h-5 w-5" name="type" id="type" value="local" @if (request('type') === 'local') checked="checked" @endif>

                                <span class="ml-2 text-gray-700 text-sm font-semibold">{{ __('Local') }}</span>
                            </label>

                            <label class="inline-flex items-center cursor-pointer ml-6">
                                <input type="radio" class="form-radio h-5 w-5" name="type" id="type" value="international" @if (request('type') === 'international') checked="checked" @endif>

                                <span class="ml-2 text-gray-700 text-sm font-semibold">{{ __('International') }}</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="block relative">
                                <select name="origin" id="origin" placeholder="{{ __('Leaving from...') }}" class="form-select mt-1 pl-10 block w-full">
                                    <option value="">{{ __('Leaving from...') }}</option>

                                    @foreach ($options['origins'] as $origin)
                                        <option @if (request('origin') === $origin) selected @endif value="{{ $origin }}">{{ $origin }}</option>
                                    @endforeach
                                </select>

                                <div class="absolute inset-y-0 flex items-center px-3">
                                    <x:heroicon-o-location-marker class="w-6 h-6 text-gray-400"/>
                                </div>
                            </label>

                            @error('origin')
                                <span class="text-sm block mt-2 text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="relative block">
                                <select name="destination" id="destination" placeholder="{{ __('Going to...') }}" class="form-select mt-1 pl-10 block w-full">
                                    <option value="">{{ __('Going to...') }}</option>

                                    @foreach ($options['destinations'] as $destination)
                                        <option @if (request('destination') === $destination) selected @endif value="{{ $destination }}">{{ $destination }}</option>
                                    @endforeach
                                </select>

                                <div class="absolute inset-y-0 flex items-center px-3">
                                    <x:heroicon-o-location-marker class="w-6 h-6 text-gray-400"/>
                                </div>
                            </label>

                            @error('destination')
                                <span class="text-sm block mt-2 text-red-500" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-4 md:mb-0">
                                <label class="relative block">
                                    <input type="datetime-local" name="departs_at" id="departs_at" value="{{ old('departsAt') ?? (request('departs_at') ?? null) }}" placeholder="{{ __('Departs') }}" autocomplete="departs_at" class="datetime form-input block w-full pl-12 mt-1 @error('departsAt') is-invalid @enderror">

                                    <div class="absolute inset-y-0 flex items-center px-3">
                                        <x:heroicon-o-calendar class="w-6 h-6 text-gray-400"/>
                                    </div>
                                </label>

                                @error('departsAt')
                                    <span class="text-sm block mt-2 text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="relative block">
                                    <input type="datetime-local" name="arrives_at" id="arrives_at" value="{{ old('arrivesAt') ?? (request('arrives_at') ?? null) }}" placeholder="{{ __('Arrives') }}" autocomplete="arrives_at" class="datetime form-input block w-full pl-12 mt-1 @error('arrivesAt') is-invalid @enderror">

                                    <div class="absolute inset-y-0 flex items-center px-3">
                                        <x:heroicon-o-calendar class="w-6 h-6 text-gray-400"/>
                                    </div>
                                </label>

                                @error('arrivesAt')
                                    <span class="text-sm block mt-2 text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-none text-base py-2 w-full">
                        Search available spaces <span class="ml-1">&rarr;</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datetime').flatpickr({
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j M Y',
                ariaDateFormat: 'Y-m-d',
                enableTime: false,
                minDate: Date.now()
            });
        });
    </script>
@endpush
