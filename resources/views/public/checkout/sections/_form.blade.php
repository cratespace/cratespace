
<div class="col-xl-6 col-lg-7 mb-6 bg-gray-200 sm:bg-transparent py-5 sm:py-0 xl:mb-0 offset-xl-1">
    <x-cards._full>
        <div>
            <h4>Pay with card</h4>
        </div>

        <form action="{{ route('spaces.orders', $space) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mt-4">
                    @include('components.forms.fields._name')
                </div>

                <div class="col-md-6 mt-4">
                    @include('components.forms.fields._business')
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-4">
                    @include('components.forms.fields._email')
                </div>

                <div class="col-md-6 mt-4">
                    @include('components.forms.fields._phone')
                </div>
            </div>

            <div class="mt-4 row">
                <div class="col-xl-9">
                    @include('components.forms.fields._credit-card')
                </div>
            </div>

            <div class="mt-4">
                <p class="text-xs text-gray-600 max-w-sm">
                    By clicking <span class="font-semibold">Pay</span>, you confirm you have read and agreed to <a href="/terms">{{ config('app.name') }} General Terms and Conditions</a> and <a href="/privacy">Privacy Policy</a>.
                </p>
            </div>

            <div class="mt-6">
                <button type="submit" class="btn btn-primary w-full">
                    Pay {{ $charges['total'] }}
                </button>
            </div>
        </form>
    </x-cards._full>
</div>
