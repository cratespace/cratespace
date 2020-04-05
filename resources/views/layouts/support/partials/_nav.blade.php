<nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4">
    <div class="container">
        <a class="block h-10" href="/">
            <img class="h-10 w-auto" src="{{ asset('img/logo-support-dark.png') }}" alt="{{ config('app.name') }}">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium" href="{{ route('listings') }}">Discussions</a>
                </li>

                <li class="nav-item ml-0 lg:ml-8">
                    <a class="nav-link font-medium" href="#">FAQ</a>
                </li>

                @auth
                    <li class="nav-item ml-0 lg:ml-8">
                        <a class="nav-link font-medium" href="{{ route('home') }}">Dashboard <span class="ml-1">&rarr;</span></a>
                    </li>
                @else
                    <li class="nav-item ml-0 lg:ml-8">
                        <a class="nav-link font-medium" href="{{ route('login') }}">Sign in <span class="ml-1">&rarr;</span></a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
