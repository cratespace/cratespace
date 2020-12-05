@props(['name' => 'popUpModal'])

<x-modals.modal name="{{ $name }}">
    <div class="flex items-start bg-white px-4 py-5 sm:px-6">
        <div class="w-10 h-10">
            <span class="inline-block bg-red-100 h-10 w-10 rounded-full flex items-center justify-center">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </span>
        </div>

        <div class="ml-5 flex-1">
            <div class="modal-header p-0">
                <h5 class="modal-title text-gray-800 font-semibold text-lg" id="{{ $name . 'Label' }}">
                    {{ $title }}
                </h5>
            </div>

            <div class="modal-body mt-3 p-0">
                {{ $content }}
            </div>
        </div>
    </div>

    <div class="modal-footer bg-white px-4 py-5 sm:px-6">
        <x-buttons.button-secondary data-dismiss="modal">No, wait!</x-buttons.button-secondary>

        <x-buttons.button-danger>Delete</x-buttons.button-danger>
    </div>
</x-modals.modal>
