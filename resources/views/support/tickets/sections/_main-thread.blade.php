<div>
    <div>
        <h3 class="leadin-snug">
            {{ $ticket->subject }}
        </h3>

        <div>
            <h6>Ticket code: <span class="text-blue-500">{{ $ticket->code }}</span></h6>
        </div>
    </div>

    <div class="mt-10 flex items-start">
        <div class="flex-no-shrink h-12 w-12">
            <a class="bg-blue-200 shadow-none px-0 h-12 w-12 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#">
                <img class="h-12 w-12" src="{{ asset('img/default.jpg') }}">
            </a>
        </div>

        <div class="ml-6 text-lg text-gray-700">
            <div>
                <h6 class="font-semibold text-gray-800 text-base">{{ $ticket->user->name }}</h6>

                <span class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</span>
            </div>

            <div class="mt-2 prose">
                {{ $ticket->description }}
            </div>

            <div class="mt-4 flex items-center">
                <a class="text-sm" href="#" role="button" data-toggle="modal" data-target="#threadModal">Edit</a>

                <a class="ml-6 text-sm" href="/">Delete</a>
            </div>
        </div>
    </div>
</div>
