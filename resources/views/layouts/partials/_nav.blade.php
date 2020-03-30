<nav class="pt-5 @guest pb-5 @endguest bg-gray-800">
    <div class="container flex justify-between items-center">
        @include('layouts.partials.nav._logo')

        <div class="hidden md:block flex-1">
            <div>
                @auth
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @include('layouts.partials.nav.links._business')
                        </div>

                        <div class="flex items-center">
                            @if (Route::currentRouteName() !== 'spaces.index')
                                <a href="{{ route('spaces.create') }}" class="-ml-3 md:ml-4 px-3 py-2 text-sm bg-indigo-500 text-white hover:bg-indigo-400 focus:bg-indigo-400 rounded-lg text-sm flex items-center whitespace-no-wrap">
                                    <svg class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>

                                    <span>New space</span>
                                </a>
                            @endif

                            <a href="{{ route('users.notifications.index', ['user' => user(), 'status' => 'Unread']) }}" class="relative inline-block ml-4 p-0 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>

                                @if (user()->unreadNotifications()->get()->count() > 0)
                                    <span class="h-3 w-3 bg-indigo-500 absolute top-0 right-0 -mt-1 -mr-1 rounded-full"></span>
                                @endif
                            </a>

                            @include('layouts.partials.nav.dropdowns._user')
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-end">
                        @include('layouts.partials.nav.links._public')
                    </div>
                @endauth
            </div>
        </div>

        <button class="navbar-toggler inline-flex md:hidden items-center justify-center text-gray-300 hover:text-white focus:outline-none focus:text-gray-400" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    @auth
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="border-b border-gray-700"></div>
                </div>
            </div>
        </div>
    @endauth

    @include('layouts.partials.nav.responsive._nav')
</nav>
