<section class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="rounded-lg shadow overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="w-full md:flex-1 bg-white px-6 py-5 border-b md:border-r border-gray-300">
                            <div class="flex items-start justify-between">
                                <div class="leading-tight">
                                    <div>
                                        <span class="font-medium text-gray-800">Total Orders</span>
                                    </div>

                                    <div class="flex items-baseline">
                                        <span class="text-3xl font-medium text-blue-500">180</span>

                                        <span class="text-gray-700 font-medium text-sm ml-1">from <span class="font-bold">675</span></span>
                                    </div>
                                </div>

                                <div>
                                    <span class="bg-green-100 text-green-800 rounded-full px-2 py-1 font-medium text-sm">12%</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full md:flex-1 bg-white px-6 py-5 border-b md:border-r border-gray-300">
                            <div class="flex items-start justify-between">
                                <div class="leading-tight">
                                    <div>
                                        <span class="font-medium text-gray-800">Total Orders</span>
                                    </div>

                                    <div class="flex items-baseline">
                                        <span class="text-3xl font-medium text-blue-500">180</span>

                                        <span class="text-gray-700 font-medium text-sm ml-1">from <span class="font-bold">675</span></span>
                                    </div>
                                </div>

                                <div>
                                    <span class="bg-green-100 text-green-800 rounded-full px-2 py-1 font-medium text-sm">12%</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full md:flex-1 bg-white px-6 py-5 border-b">
                            <div class="flex items-start justify-between">
                                <div class="leading-tight">
                                    <div>
                                        <span class="font-medium text-gray-800">Total Orders</span>
                                    </div>

                                    <div class="flex items-baseline">
                                        <span class="text-3xl font-medium text-blue-500">180</span>

                                        <span class="text-gray-700 font-medium text-sm ml-1">from <span class="font-bold">675</span></span>
                                    </div>
                                </div>

                                <div>
                                    <span class="bg-green-100 text-green-800 rounded-full px-2 py-1 font-medium text-sm">12%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white px-6 py-5">
                        <div>
                            <span class="font-medium text-gray-800">Orders This Week</span>
                        </div>

                        <graph class="-ml-4" :keys="{{ $chart->keys() }}" :values="{{ $chart->values() }}"></graph>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                @include('business.dashboard.sections._pending-orders')
            </div>
        </div>
    </div>
</section>
