<section {{ $attributes->merge(['class' => 'pb-6 bg-gray-800']) }}>
    <div class="container mx-auto px-4 sm:px-6">
        <div class="row">
            <div class="col-12">
                <div class="border-t border-gray-700 mb-6"></div>

                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>
