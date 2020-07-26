<div>
    <div class="mt-6">
        <label class="block">
            <span class="text-gray-700 text-sm font-semibold">{{ __('Card number') }}</span>

            <input type="tel" name="card_number" id="card_number" class="form-input mt-1 block w-full @error('card_number') placeholder-red-500 border-red-300 bg-red-100 @enderror" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="4242 4242 4242 4242" value="{{ old('card_number') ?? ($card_number ?? null) }}">
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

                <input type="tel" name="cvc" id="cvc" class="form-input mt-1 block w-full @error('cvc') placeholder-red-500 border-red-300 bg-red-100 @enderror" inputmode="numeric" pattern="[0-9\s]{3,4}" autocomplete="cvc" maxlength="3" placeholder="000" value="{{ old('cvc') ?? ($cvc ?? null) }}">
            </label>

            @error('cvc')
                <div class="mt-2 whitespace-normal" role="alert">
                    <span class="text-xs text-red-500 font-semibold whitespace-normal">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <div class="mt-6">
        <label class="block">
            <span class="text-gray-700 text-sm font-semibold">{{ __('Expiration date') }}</span>

            <div class="row mt-1">
                <div class="col-7">
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
                </div>

                <div class="col-5">
                    <select class="form-select block w-full" name="expiration_year" id="expiration_year">
                        @foreach (range(date('Y'), date('Y') + 10) as $year)
                            <option value="{{ $year }}"> {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </label>

        @error('expiration_month')
            <div class="mt-2" role="alert">
                <span class="text-xs text-red-500 font-semibold">{{ __('Expiration month or year is invalid') }}</span>
            </div>
        @enderror
    </div>
</div>
