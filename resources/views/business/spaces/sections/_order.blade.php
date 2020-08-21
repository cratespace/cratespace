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
                <div class="dropdown">
                    <a class="btn btn-secondary inline-flex items-center dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2">{{ $order->status }}</span>
                        <x:heroicon-o-chevron-down class="w-4 h-4"/>
                    </a>

                    <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                        @foreach (config('defaults.orders.statuses') as $status)
                            @if ($order->status !== $status)
                                <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('orders.update', $order) }}" onclick="event.preventDefault(); document.getElementById('order-update-form').submit();">
                                    {{ $status }}
                                </a>

                                <form id="order-update-form" action="{{ route('orders.update', $order) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="status" value="{{ $status }}">
                                </form>
                            @endif
                        @endforeach
                    </div>
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
