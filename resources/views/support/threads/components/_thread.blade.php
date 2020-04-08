<a href="{{ $thread->path() }}" class="mb-6 flex group whitespace-normal">
    <div class="h-4 w-4 mt-1">
        <svg class="h-4 w-4 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
        </svg>
    </div>

    <div class="ml-4 group">
        <div class="text-indigo-500 group-hover:text-indigo-400 whitespace-normal">
            {{ $thread->title }}
        </div>

        <div class="mt-2 max-w-2xl">
            <p class="text-sm text-gray-600 whitespace-normal leading-relaxed">
                {{ get_excerpt(parse($thread->body), 200) }}
            </p>
        </div>
    </div>
</a>
