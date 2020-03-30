<div>
    <form id="payment-form" action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <div>
                <h3 class="text-xl text-gray-800 font-semibold">Basic Information</h3>
            </div>

            <hr class="my-6">

            <div class="mb-6">
                @include('components.forms.fields._name')
            </div>

            <div class="mb-6">
                @include('components.forms.fields._business')

                <div role="alert">
                    <span class="text-xs text-gray-500">If you are an individual, specify as <span class="font-semibold">Independent</span>.</span>
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
                <h3 class="text-xl text-gray-800 font-semibold">Payment Information</h3>
            </div>

            <hr class="my-6">

            <div>
                <label class="block rounded-lg overflow-hidden shadow cursor-pointer">
                    <div class="bg-white px-4 py-5 sm:px-6">
                        <div class="flex items-start">
                            <input type="radio" class="form-radio text-indigo-500" name="payment_type" id="payment_type" value="credit_card" checked>

                            <div class="ml-4">
                                <div class="text-base font-semibold">Credit Card</div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Safe money transfer using your bank account. Visa, Maestro, Discover, American Express.
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="mt-6">
                                <label class="block">
                                    <span class="text-gray-700 text-sm font-semibold">{{ __('Card number') }}</span>

                                    <input type="tel" name="card_number" id="card_number" class="form-input mt-1 block w-full @error('card_number') placeholder-red-500 border-red-300 bg-red-100 @enderror" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" value="{{ old('card_number') ?? ($card_number ?? null) }}">
                                </label>

                                @error('card_number')
                                    <div class="mt-2" role="alert">
                                        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-lg-8 mt-6">
                                    <label class="block">
                                        <span class="text-gray-700 text-sm font-semibold">{{ __('Name on card') }}</span>

                                        <input type="text" name="name_on_card" id="name_on_card" class="form-input mt-1 block w-full @error('name_on_card') placeholder-red-500 border-red-300 bg-red-100 @enderror" placeholder="J DOE" value="{{ old('name_on_card') ?? ($name_on_card ?? null) }}">
                                    </label>

                                    @error('name_on_card')
                                        <div class="mt-2" role="alert">
                                            <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mt-6">
                                    <label class="block">
                                        <span class="text-gray-700 text-sm font-semibold">{{ __('CVV Code') }}</span>

                                        <input type="tel" name="cvv" id="cvv" class="form-input mt-1 block w-full @error('cvv') placeholder-red-500 border-red-300 bg-red-100 @enderror" inputmode="numeric" pattern="[0-9\s]{3,4}" autocomplete="cvv" maxlength="3" placeholder="000" value="{{ old('cvv') ?? ($cvv ?? null) }}">
                                    </label>

                                    @error('cvv')
                                        <div class="mt-2 whitespace-normal" role="alert">
                                            <span class="text-xs text-red-500 font-semibold whitespace-normal">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 mt-6">
                                    <label class="block">
                                        <span class="text-gray-700 text-sm font-semibold">{{ __('Expiration date') }}</span>

                                        <div class="flex items-center mt-1">
                                            <select class="form-select block w-full" name="expiration_month" id="expiration_month">
                                                <option value="01">January</option>
                                                <option value="02">February </option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                            <select class="ml-4 form-select block w-full" name="expiration_year" id="expiration_year">
                                                <option value="16"> 2016</option>
                                                <option value="17"> 2017</option>
                                                <option value="18"> 2018</option>
                                                <option value="19"> 2019</option>
                                                <option value="20"> 2020</option>
                                                <option value="21"> 2021</option>
                                            </select>
                                        </div>
                                    </label>

                                    @error('expiration_month')
                                        <div class="mt-2" role="alert">
                                            <span class="text-xs text-red-500 font-semibold">{{ __('Expiration month or year is invalid') }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </label>

                <label class="mt-6 block rounded-lg overflow-hidden shadow cursor-pointer">
                    <div class="bg-white px-4 py-5 sm:px-6">
                        <div class="flex items-start">
                            <input type="radio" class="form-radio text-indigo-500" name="payment_type" id="payment_type" value="cash">

                            <div class="ml-4">
                                <div class="text-base font-semibold">Cash on delivery</div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Pay exporter business after delivering your goods to be exported using the space you are purchasing.
                                </p>
                            </div>
                        </div>
                    </div>
                </label>

                <div class="mt-10">
                    <button type="submit" class="btn btn-primary w-full">Book Space</button>
                </div>
            </div>
        </div>
    </form>
</div>
