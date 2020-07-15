<section class="bg-gray-200 py-8">
    <div class="container">
        <div class="row">
            @forelse (range(1, 2) as $element)
                <div class="col-lg-4 col-md-6 flex flex-col mb-8">
                    <x-cards._full hasFooter="true">
                        <div class="flex justify-between items-start">
                            <div class="leading-snug">
                                <span class="text-blue-500 font-bold text-sm uppercase">UYH76IA7</span>

                                <div class="text-sm">
                                    Sunny Super Side Exports
                                </div>
                            </div>

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Local
                            </span>
                        </div>

                        <hr class="my-4">

                        <div class="flex justify-between">
                            <div>
                                <div>
                                    <div class="text-xs">Departure</div>
                                    <div class="text-sm text-gray-700 font-medium">Jan 12, 9:00am</div>
                                    <div class="text-sm text-gray-700">from <span class="font-medium">Trincomalee</span></div>
                                </div>

                                <div class="mt-4">
                                    <div class="text-xs">Arrival</div>
                                    <div class="text-sm text-gray-700 font-medium">Jan 12, 9:00pm</div>
                                    <div class="text-sm text-gray-700">to <span class="font-medium">Colombo</span></div>
                                </div>
                            </div>

                            <div class="text-right flex flex-col justify-between items-end">
                                <div>
                                    <div class="text-xs">Dimensions</div>
                                    <div><span class="font-bold text-gray-700">25</span> (cu ft)</div>
                                    <div class="text-sm">5 x 6 x 2 (ft)</div>
                                </div>

                                <div class="mt-4">
                                    <div class="text-blue-500 font-bold">$12</div>
                                </div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <a class="btn btn-primary block w-full text-center rounded-none py-2" href="/">Book now <span class="ml-1">&rarr;</span></a>
                        </x-slot>
                    </x-cards._full>
                </div>
            @empty
                <div class="col-12">
                    <span class="text-sm">No spaces available</span>
                </div>
            @endforelse
        </div>
    </div>
</section>
