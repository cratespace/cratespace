@if (!is_null($order))
    <x-cards._full bgColor="bg-gray-100" shadow="shadow-none">
        <div class="flex items-start justify-between">
            <div>
                <h6 class="text-base leading-6 font-semibold text-gray-800">
                    {{ $order->confirmation_number }}
                </h6>

                <p class="max-w-2xl text-sm leading-5">
                    Customer and charge details.
                </p>
            </div>

            <div>
                <div>
                    <order-update-status :order="{{ $order }}" :statuses="{{ json_encode(config('defaults.orders.statuses')) }}" ></order-update-status>
                </div>
            </div>
        </div>

        <hr class="my-6">

        <div>
            <dl>
                <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm leading-5 font-medium">
                        Name
                    </dt>

                    <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                        <span class="font-medium">{{ $order->name }}</span>
                    </dd>
                </div>

                <div class="mt-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm leading-5 font-medium">
                        Email
                    </dt>

                    <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                        <a href="mailto:{{ $order->email }}" class="font-medium">{{ $order->email }}</a>
                    </dd>
                </div>

                <div class="mt-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm leading-5 font-medium">
                        Phone
                    </dt>

                    <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                        <span class="font-medium">{{ $order->phone }}</span>
                    </dd>
                </div>

                <hr class="my-6">

                <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm leading-5 font-medium">
                        Charges
                    </dt>

                    <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                        <div class="flex items-baseline justify-between">
                            <span>Full price</span>

                            <span class="font-medium">{{ $space->present()->fullPrice }}</span>
                        </div>

                        <div class="flex items-baseline justify-between mt-2">
                            <span>Service</span>

                            <span class="font-medium">{{ $order->present()->service }}</span>
                        </div>

                        <div class="flex items-baseline justify-between mt-2">
                            <span>Tax</span>

                            <span class="font-medium">{{ $order->present()->tax }}</span>
                        </div>

                        <div class="flex items-baseline justify-between mt-2">
                            <span class="font-bold">Total</span>

                            <span class="font-bold">{{ $order->present()->total }}</span>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </x-cards._full>
@endif
