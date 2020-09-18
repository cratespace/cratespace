<nav class="bg-gray-800">
    <div class="container">
        <div class="h-16 flex justify-between items-center border-b border-gray-700">
            <a class="block flex-shrink-0 h-8 w-auto" href="/" title="{{ config('app.name') }}">
                <img class="h-8 w-auto" src="{{ asset('img/logo-light.png') }}" alt="{{ config('app.name') }}">
            </a>

            <div class="ml-10 flex flex-1 items-center justify-end md:justify-between">
                <ul class="hidden md:flex items-center">
                    <li>
                        <a class="{{ is_active('home', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-gray-600" href="/home">{{ __('Dashboard') }}</a>
                    </li>

                    <li class="ml-6">
                        <a class="{{ is_active('orders*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white" href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
                    </li>

                    <li class="dropdown ml-6">
                        <a class="{{ is_active('spaces*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Spaces') }}</a>

                        <div class="mt-3 dropdown-menu rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.index') }}">{{ __('All spaces') }}</a>

                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('spaces.create') }}">{{ __('New space') }}</a>
                        </div>
                    </li>

                    <li class="ml-6">
                        <a class="{{ is_active('support*', 'bg-gray-700 bg-opacity-50') }} block px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 hover:bg-opacity-50 focus:text-white active:text-white" href="/support">{{ __('Support') }}</a>
                    </li>
                </ul>

                <ul class="flex items-center">
                    <li class="dropdown block md:hidden">
                        <a class="shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <x:heroicon-o-menu class="w-6 h-6 text-gray-600"/>
                        </a>

                        <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="home">{{ __('Dashboard') }}</a>

                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="orders">{{ __('Orders') }}</a>

                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="spaces">{{ __('Spaces') }}</a>

                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="/support">{{ __('Support') }}</a>
                        </div>
                    </li>

                    <li class="ml-4 dropdown">
                        <a class="bg-blue-200 shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="h-8 w-8" src="{{ user('profile_photo_url') }}" alt="{{ user('name') }}">
                        </a>

                        <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('users.edit', user()) }}">{{ __('Settings') }}</a>

                            <a class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Sign out') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
