<div>
    <form id="payment-form" action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <div>
                <h3 class="text-xl text-gray-600">Basic Information</h3>
            </div>

            <hr class="my-6">

            <div class="mb-6">
                @include('components.forms.fields._name')
            </div>

            <div class="mb-6">
                @include('components.forms.fields._business')

                <div role="alert">
                    <span class="text-xs text-gray-500">If you are an individual, you can leave this field unfilled.</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._phone')
                </div>

                <div class="col-lg-6 mb-6">
                    @include('components.forms.fields._email')
                </div>
            </div>
        </div>

        <div>
            <div>
                <h3 class="text-xl text-gray-600">Payment Information</h3>
            </div>

            <hr class="my-6">

            <div>
                <div class="hidden">
                    <div class="mb-6">
                        <label class="block">
                            <span class="text-gray-700 text-sm font-semibold">Name on card</span>

                            <input name="name_on_card" id="name_on_card" type="text" class="form-input mt-1 block w-full @error('name_on_card') placeholder-red-500 border-red-300 bg-red-100 @enderror" value="{{ old('name_on_card') }}" placeholder="D John">
                        </label>

                        @error('name_on_card')
                            <div class="mt-2" role="alert">
                                <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-10">
                        <div>
                            <span class="text-gray-700 text-sm font-semibold">Card details</span>

                            <div class="rounded-md shadow-sm mt-1">
                                <div>
                                    <input aria-label="Card number" name="card_number" id="card_number" type="text" class="form-input appearance-none rounded-none relative block w-full rounded-t-lg focus:z-10" placeholder="Card number" />
                                </div>

                                <div class="-mt-px flex">
                                    <input aria-label="MM / YY" name="card_expires_at" id="card_expires_at" type="text" class="form-input datetime appearance-none rounded-none relative block w-full rounded-bl-lg focus:outline-none focus:z-10" placeholder="MM / YY" />

                                    <input aria-label="CCV" name="card_cvc" id="card_cvc" type="text" class="form-input appearance-none rounded-none relative block w-full rounded-br-lg focus:outline-none focus:z-10" placeholder="CCV" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-full">
                        Pay {{ '$' . $pricing['total'] . ' USD' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
