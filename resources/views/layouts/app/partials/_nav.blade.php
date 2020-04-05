<nav class="navbar navbar-expand-lg navbar-dark py-4">
    <div class="container">
        <a class="block h-10" href="/">
            <img class="h-10 w-auto" src="{{ asset('img/logo-light.png') }}" alt="{{ config('app.name') }}">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto items-center">
                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium text-sm" href="{{ route('home') }}">Dashboard</a>
                </li>

                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium text-sm" href="{{ route('spaces.index') }}">Spaces</a>
                </li>

                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium text-sm" href="{{ route('orders.index') }}">Orders</a>
                </li>

                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium text-sm" href="#">Report</a>
                </li>

                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium text-sm" href="{{ route('support.threads.index') }}">Support</a>
                </li>

                <li class="dropdown nav-item ml-0 lg:ml-8">
                    <button class="dropdown-toggle max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="h-8 w-8 rounded-full" src="{{ user('photo') }}" alt="{{ user('name') }}" />
                    </button>

                    <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
                        <a href="#" class="dropdown-item block px-4 py-2 text-sm">Settings</a>
                        <a class="dropdown-item block px-4 py-2 text-sm" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Sign out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

