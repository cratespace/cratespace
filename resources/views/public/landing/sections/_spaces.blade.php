<section class="bg-gray-200 pt-8 pb-2">
    <div class="container">
        <div class="row">
            @forelse ($spaces as $space)
                <div class="col-lg-4 col-md-6 flex flex-col mb-8">
                    <x-cards._full hasFooter="true">
                        <div class="flex justify-between items-start">
                            <div class="leading-snug">
                                <span class="text-blue-500 font-bold text-sm">{{ $space->uid }}</span>

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
                                    <div class="text-xs">Departure</div>
                                    <div class="text-sm text-gray-700 font-medium">{{ $space->departs_at->format('M j, g:ia') }}</div>
                                    <div class="text-sm text-gray-700">from <span class="font-medium">{{ $space->origin }}</span></div>
                                </div>

                                <div class="mt-6">
                                    <div class="text-xs">Arrival</div>
                                    <div class="text-sm text-gray-700 font-medium">{{ $space->arrives_at->format('M j, g:ia') }}</div>
                                    <div class="text-sm text-gray-700">to <span class="font-medium">{{ $space->destination }}</span></div>
                                </div>
                            </div>

                            <div class="text-right flex flex-col justify-between items-end">
                                <div>
                                    <div class="text-xs">Dimensions</div>
                                    <div><span class="font-bold text-gray-700">25</span> (cu ft)</div>
                                    <div class="text-sm">5 x 6 x 2 (ft)</div>
                                </div>

                                <div class="mt-6">
                                    <div class="text-blue-500 font-bold">{{ $space->price }}</div>
                                </div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <a class="btn btn-primary block w-full text-center rounded-none py-1" href="#" data-toggle="modal" data-target="#purchaseSpaceModal{{ $space->uid }}">Book now <span class="ml-1">&rarr;</span></a>
                        </x-slot>
                    </x-cards._full>
                </div>

                <!-- Purchase Space Modal -->
                <div class="modal fade" id="purchaseSpaceModal{{ $space->uid }}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="purchaseSpaceModal{{ $space->uid }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl rounded-lg overflow-hidden">
                        <div class="modal-content rounded-lg overflow-hidden shadow-lg">
                            <div class="modal-body p-0">
                                <div class="row no-gutters">
                                    <div class="col-lg-6 flex flex-col">
                                        <div class="flex flex-col flex-1 justify-between p-6">
                                            <div class="flex justify-between items-start">
                                                <div class="leading-snug">
                                                    <span class="text-blue-500 font-bold text-lg">{{ $space->uid }}</span>

                                                    <div>
                                                        {{ $space->business }}
                                                    </div>
                                                </div>

                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $space->type }}
                                                </span>
                                            </div>

                                            <hr class="my-6">

                                            <div>
                                                <div>
                                                    <div class="text-sm">Departure</div>
                                                    <div class="text-gray-700 font-medium">{{ $space->departs_at->format('M j, g:ia') }}</div>
                                                    <div class="text-gray-700">from <span class="font-medium">{{ $space->origin }}</span></div>
                                                </div>

                                                <div class="mt-6">
                                                    <div class="text-sm">Arrival</div>
                                                    <div class="text-gray-700 font-medium">{{ $space->arrives_at->format('M j, g:ia') }}</div>
                                                    <div class="text-gray-700">to <span class="font-medium">{{ $space->destination }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 flex flex-col bg-gray-100">
                                        <form action="" method="POST" class="flex flex-col flex-1 justify-between p-6">
                                            <div>
                                                @csrf

                                                <label class="block rounded-lg overflow-hidden shadow cursor-pointer">
                                                    <div class="bg-white px-4 py-5 sm:px-6">
                                                        <div class="flex items-start">
                                                            <input type="radio" class="form-radio" name="payment_type" id="payment_type" value="credit_card" checked>

                                                            <div class="ml-4">
                                                                <div class="text-base font-semibold text-gray-800">Credit Card</div>

                                                                <p class="mt-1 text-sm">
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
                                                            <input type="radio" class="form-radio" name="payment_type" id="payment_type" value="cash">

                                                            <div class="ml-4">
                                                                <div class="text-base font-semibold text-gray-800">Cash on delivery</div>

                                                                <p class="mt-1 text-sm">
                                                                    Pay <span class="font-bold">{{ $space->business }}</span> after delivering your goods. Space <span class="font-bold">{{ $space->uid }}</span> will be marked as booked and <span class="font-bold">{{ $space->business }}</span> will be notified.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="mt-8 flex justify-between items-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                                                <button type="button" class="ml-3 btn btn-primary">Book space</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
