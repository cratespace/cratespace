<section class="py-6 bg-gray-800">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="mr-4 mb-6 lg:mb-0">
                        <a class="block rounded-full h-16 w-16 overflow-hidden" href="/home">
                            <img class="h-16 w-16 rounded-full" src="{{ user()->business->image }}" alt="{{ user()->business->name }}" />
                        </a>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start">
                            <h2 class="text-xl font-bold text-white leading-tight">
                                {{ user()->business->name }}
                            </h2>

                            @if (user('email_verified_at'))
                                <svg class="flex-shrink-0 mr-2 h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>

                        <div class="mt-1">
                            <a href="mailto:{{ user()->business->email }}" class="inline-flex items-center text-sm text-gray-300 hover:text-gray-400">
                                <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>

                                <span class="font-medium">{{ user()->business->email }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>