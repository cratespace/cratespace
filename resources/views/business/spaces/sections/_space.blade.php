<div class="flex items-start justify-between">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-800">
            Space Information
        </h3>

        <p class="max-w-2xl text-sm leading-5">
            Departure, dimensions and price details.
        </p>
    </div>

    <div>
        <a class="btn btn-secondary inline-flex items-center" href="{{ route('spaces.edit', $space) }}">
            <x:heroicon-o-pencil class="w-4 h-4"/> <span class="ml-2">Edit</span>
        </a>
    </div>
</div>

<hr class="my-6">

<div>
    <dl>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                UID/Hash Code
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <span class="font-medium">{{ $space->code }}</span>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Type
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <span class="font-medium">{{ $space->type }}</span>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Dimensions
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <div>
                    <span class="font-medium">{{ $space->present()->volume }}</span> (cu ft)
                </div>

                <div class="text-sm text-gray-500">{{ $space->height }} x {{ $space->weight }} x {{ $space->length }} (ft)</div>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Max. allowable weight
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <div>
                    <span class="font-medium">{{ $space->weight }}</span> (Kg)
                </div>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Schedule
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <div>
                    <div>Leaves <span class="font-medium">{{ $space->schedule->departsAt }}</span></div>
                    <div class="text-xs text-gray-500">{{ $space->departs_at->diffForHumans() }}</div>
                </div>

                <div class="mt-2">
                    <div>Arrives <span class="font-medium">{{ $space->schedule->arrivesAt }}</span></div>
                    <div class="text-xs text-gray-500">{{ $space->arrives_at->diffForHumans() }}</div>
                </div>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Travel from/to
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <div>
                    From <span class="font-medium">{{ $space->origin }}</span>
                </div>

                <div class="mt-2">
                    To <span class="font-medium">{{ $space->destination }}</span>
                </div>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Pricing
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                <div>
                    Original price <span class="font-medium">{{ $space->present()->price }}</span>
                </div>

                <div class="mt-2">
                    Tax <span class="font-medium">{{ $space->present()->tax }}</span>
                </div>

                <div class="mt-2">
                    Full price <span class="font-medium">{{ $space->present()->fullPrice }}</span>
                </div>
            </dd>
        </div>

        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm leading-5 font-medium text-gray-500">
                Addtional information
            </dt>

            <dd class="mt-1 text-sm leading-5 text-gray-800 sm:mt-0 sm:col-span-2">
                {{ $space->note }}
            </dd>
        </div>
    </dl>
</div>
