<section class="bg-white py-8 shadow">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-sm text-center">
                    @if (request()->is('/'))
                        Showing <span class="font-bold">120</span> spaces both <span class="font-bold">local</span> and <span class="font-bold">interational</span>
                    @else
                        Looking for space available from <span class="font-bold">Trincomalee</span> going to <span class="font-bold">Colombo</span>, leaving on <span class="font-bold">Wednesday, Jan 12</span> and arriving on <span class="font-bold">Wednesday, Jan 12</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
