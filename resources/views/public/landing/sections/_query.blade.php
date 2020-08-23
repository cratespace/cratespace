<section class="bg-white py-4 shadow">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        Showing spaces from <span class="font-semibold text-blue-500">{{ Location::getCountry() ?? 'Sri Lanka' }}</span>
                    </div>

                    <div class="text-sm text-center">
                        @if (request('type'))
                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-medium text-blue-800 mr-2">{{ ucfirst(request('type')) }}</span>
                        @endif

                        @if (request('origin'))
                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-medium text-blue-800 mr-2">{{ ucfirst(request('origin')) }}</span>
                        @endif

                        @if (request('destination'))
                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-medium text-blue-800 mr-2">{{ ucfirst(request('destination')) }}</span>
                        @endif

                        @if (request('departs_at'))
                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-medium text-blue-800 mr-2">{{ Carbon\Carbon::parse(request('departs_at'))->format('F j, Y') }}</span>
                        @endif

                        @if (request('arrives_at'))
                            <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-medium text-blue-800 mr-2">{{ Carbon\Carbon::parse(request('arrives_at'))->format('F j, Y') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
