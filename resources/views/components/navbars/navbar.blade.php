<nav {{ $attributes->merge(['class' => 'h-16']) }}>
    <div class="container mx-auto max-w-7xl min-h-full h-full px-4 sm:px-6">
        <div class="flex items-center justify-between h-full">
            {{ $logo }}

            <div class="ml-6 flex flex-1 items-center">
                <div class="hidden md:flex items-center mr-auto">
                    {{ $linksLeft }}
                </div>

                <div class="flex items-center ml-auto">
                    {{ $linksRight }}
                </div>
            </div>
        </div>
    </div>
</nav>
