<div>
    <div class="text-blue-600 font-semibold text-sm">{{ '#' . $order->confirmation_number }}</div>
    <h4><span class="font-normal">Arrives</span> {{ $order->space->arrives_at->format('D, M j') }}</h4>
</div>

<div class="mt-8">
    <order-status></order-status>
</div>

<div class="mt-6">
    <div class="text-sm">
        Tracking information will be available in 24 hours. Tracking system is real-time and does not require the web page to be reloaded.
    </div>
</div>

<div>
    <hr class="my-6">

    <h5>Payment Information</h5>

    <div class="mt-4">
        <p>
            <div>
                <span class="text-gray-800">Order total <span class="text-blue-500 font-bold">{{ $order->present()->total }}</span></span>
            </div>

            <div class="mt-1 text-sm">
                Payment was <span class="px-2 py-1 text-xs rounded-full font-semibold text-green-800 bg-green-100 uppercase">Successful</span>
            </div>

            <div class="mt-4">
                Billed to card ending with <span class="ml-1 font-mono tracking-widest rounded-lg px-2 py-1 bg-gray-200 text-sm font-medim">**** **** **** {{ $order->charge->card_last_four }}</span>
            </div>
        </p>
    </div>

    <hr class="my-6">

    <h5>Customer Information</h5>

    <div class="mt-4">
        <p>
            <div class="font-medium text-gray-800">{{ $order->name }}</div>
            <div class="text-blue-500">{{ $order->email }}</div>
            <div>{{ $order->phone }}</div>
            <div class="mt-1 font-medium text-sm">{{ $order->business }}</div>
        </p>
    </div>
</div>
