<nav class="navbar navbar-expand-lg navbar-dark bg-transparent py-4">
    <div class="container">
        <a class="navbar-brand h-10" href="/">
            <img class="h-10 w-auto" src="{{ asset('img/logo-light.png') }}" alt="{{ config('app.name') }}">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @include('layouts.partials.links._public')
            </ul>
        </div>
    </div>
</nav>
