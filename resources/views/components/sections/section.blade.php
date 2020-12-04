<section {{ $attributes->merge(['class' => 'py-16']) }}>
    <div class="container mx-auto px-4 sm:px-6">
        <div class="row">
            {{ $slot }}
        </div>
    </div>
</section>
