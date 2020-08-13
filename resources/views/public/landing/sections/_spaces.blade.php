<section class="bg-gray-200 pt-8 pb-2">
    <div class="container">
        <div class="row">
            @forelse ($spaces as $space)
                <div class="col-lg-4 col-md-6 flex flex-col mb-8">
                    <x-cards._full hasFooter="true">
                        <div class="flex justify-between items-start">
                            <div class="leading-snug">
                                <span class="text-blue-500 font-bold text-sm">{{ $space->code }}</span>

                                <div class="text-sm">
                                    {{ $space->business }}
                                </div>
                            </div>

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $space->type }}
                            </span>
                        </div>

                        <hr class="my-6">

                        <div class="flex justify-between">
                            <div>
                                <div>
                                    <div class="flex items-center">
                                        <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Departure</div>
                                    </div>

                                    <div class="text-sm text-gray-700 font-medium">{{ $space->schedule->departsAt }}</div>

                                    <div class="text-sm text-gray-700">from <span class="font-medium">{{ $space->origin }}</span></div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex items-center">
                                        <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Arrival</div>
                                    </div>

                                    <div class="text-sm text-gray-700 font-medium">{{ $space->schedule->arrivesAt }}</div>

                                    <div class="text-sm text-gray-700">to <span class="font-medium">{{ $space->destination }}</span></div>
                                </div>
                            </div>

                            <div class="text-right flex flex-col justify-between items-end">
                                <div>
                                    <div class="flex items-center">
                                        <x:heroicon-o-arrows-expand class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Dimensions</div>
                                    </div>

                                    <div><span class="font-bold text-gray-700">{{ $space->present()->volume }}</span> (cu ft)</div>

                                    <div class="text-sm">{{ $space->height }} x {{ $space->weight }} x {{ $space->length }} (ft)</div>
                                </div>

                                <div class="mt-6">
                                    <div class="text-blue-500 font-bold">{{ $space->present()->fullPrice }}</div>
                                </div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <a class="btn btn-primary block w-full text-center rounded-none py-1" href="{{ route('checkout', $space) }}">Book now <span class="ml-1">&rarr;</span></a>
                        </x-slot>
                    </x-cards._full>
                </div>
            @empty
                <div class="col-12 mb-6">
                    <span class="text-sm flex items-center">
                        <x:heroicon-o-information-circle class="w-4 h-4 text-gray-500"/> <span class="ml-1">No spaces available</span>
                    </span>
                </div>
            @endforelse
        </div>
    </div>
</section>

@if (! $spaces->isEmpty())
    <section class="py-8 bg-gray-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        {{ $spaces->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
