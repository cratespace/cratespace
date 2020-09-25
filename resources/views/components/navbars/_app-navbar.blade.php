<nav class="bg-gray-800">
    <div class="container">
        <div class="h-16 flex justify-between items-center border-b border-gray-700">
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
