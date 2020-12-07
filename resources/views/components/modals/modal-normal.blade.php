@props(['name' => 'popUpModal'])

<x-modals.modal name="{{ $name }}">
    <div class="modal-header bg-white px-4 pt-5 pb-0 sm:px-6">
        <h5 class="modal-title text-gray-800 font-semibold text-lg" id="{{ $name . 'Label' }}">
            {{ $title }}
        </h5>
    </div>

    <div class="modal-body bg-white px-4 pb-5 pb-0 sm:px-6">
        {{ $content }}
    </div>

    <div class="modal-footer bg-gray-200 px-4 py-5 sm:px-6">
        <x-buttons.button-secondary data-dismiss="modal">I change my mind</x-buttons.button-secondary>

        <x-buttons.button-primary>Yes, I am</x-buttons.button-primary>
    </div>
</x-modals.modal>
