@props(['name' => null, 'action' => null])

<div class="modal fade" id="{{ $name }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="{{ $name }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ $action }}" method="POST" class="relative modal-content rounded-lg shadow-lg overflow-hidden">
            @csrf

            <div class="modal-body">
                <button type="button" class="absolute top-0 right-0 mr-3 mt-2 font-normal close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div>
                    {{ $content }}
                </div>
            </div>

            <div class="modal-footer bg-gray-100">
                {{ $footer }}
            </div>
        </form>
    </div>
</div>
