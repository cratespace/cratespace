<nav class="py-4 {{ $bgNav ?? 'bg-white' }}">
    <div class="container">
        <div class="flex justify-between items-center">
            <a class="block h-10 w-10" href="/" title="{{ config('app.name') }}">
                <img class="h-10 w-10" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
            </a>

            <div class="ml-10 hidden md:flex flex-1 items-center justify-between">
                <ul class="flex items-center">
                    <li>
                        <a class="text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-gray-600 active:text-gray-600" href="/listings">{{ __('Listings') }}</a>
                    </li>

                    <li class="ml-6">
                        <a class="text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-gray-600 active:text-gray-600" href="/businesses">{{ __('Businesses') }}</a>
                    </li>

                    <li class="ml-6">
                        <a class="text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-gray-600 active:text-gray-600" href="/pricing">{{ __('Pricing') }}</a>
                    </li>

                    <li class="ml-6">
                        <a class="text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-gray-600 active:text-gray-600" href="/support">{{ __('Support') }}</a>
                    </li>
                </ul>

                <ul class="flex items-center">
                    <li class="ml-6">
                        <a class="text-sm font-semibold text-white hover:text-white focus:text-white rounded-full px-4 py-2 bg-blue-100 bg-opacity-25 hover:bg-opacity-50" href="{{ route('login') }}">{{ __('Sign in') }} <span class="ml-1">&rarr;</span></a>
                    </li>
                </ul>
            </div>

            <div class="dropdown block md:hidden">
                <a class="bg-blue-100 shadow-none bg-opacity-25 hover:bg-opacity-75 focus:bg-opacity-75 active:bg-opacity-75 px-0 h-10 w-10 flex items-center justify-center rounded-full dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <x:heroicon-o-menu class="w-6 h-6 text-white"/>
                </a>

                <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-white active:text-white py-2" href="#">{{ __('Listings') }}</a>
                    <a class="dropdown-item text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-white active:text-white py-2" href="#">{{ __('Businesses') }}</a>
                    <a class="dropdown-item text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-white active:text-white py-2" href="#">{{ __('Pricing') }}</a>
                    <a class="dropdown-item text-sm font-semibold text-gray-500 hover:text-gray-600 focus:text-white active:text-white py-2" href="#">{{ __('Support') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-sm font-semibold text-blue-500 hover:text-blue-600 focus:text-white active:text-white py-2" href="{{ route('login') }}">{{ __('Sign in') }} <span class="ml-1">&rarr;</span></a>
                </div>
            </div>
        </div>
    </div>
</nav>
