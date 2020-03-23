<div class="container collapse block md:hidden" id="navbarToggleExternalContent">
    <div class="py-5 flex flex-col justify-center border-b border-gray-700">
        @auth
            <div class="row">
                <div class="col-6 flex flex-col justify-center">
                    @include('layouts.partials.nav.links._business')
                </div>

                <div class="col-6 flex justify-end">
                    @include('layouts.partials.nav.dropdowns._user')
                </div>
            </div>
        @else
            @include('layouts.partials.nav.links._public')
        @endauth
    </div>
</div>
