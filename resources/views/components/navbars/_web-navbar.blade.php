<nav class="py-4 {{ $bgNav ?? 'bg-white' }} border-b border-gray-200">
    <div class="container">
        <div class="flex justify-between items-center">
            {{ $slot }}

            <div class="ml-10 flex flex-1 items-center justify-end md:justify-between">
                <ul class="hidden md:flex items-center">
                    {{ $leftMenu }}
                </ul>

                <ul class="flex items-center">
                    {{ $rightMenu }}
                </ul>
            </div>
        </div>
    </div>
</nav>
