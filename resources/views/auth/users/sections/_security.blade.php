<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Security
            </h4>

            <p class="text-sm max-w-sm">
                Take care while you handle these settings. These actions will cause permanent loss of data.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <div>
            <h5 class="text-lg font-medium text-gray-800 mb-3">
                Delete your account
            </h5>

            <p class="text-sm mb-6">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>

            <div>
                <button class="btn bg-red-200 text-red-800" type="button" data-toggle="modal" data-toggle="modal" data-target="#deleteFormModal">
                    Delete account
                </button>
            </div>
        </div>
    </div>
</div>

@push('modals')
    <x-modals._form-modal :name="'deleteFormModal'" :action="route('users.destroy', $user)">
        <x-slot name="content">
            @method('DELETE')

            <h5 class="text-lg font-medium text-gray-800 mb-3">
                Confirm Account Deletion
            </h5>

            <p class="text-sm text-gray-600">
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="row">
                <div class="mt-4 col-md-9">
                    @include('components.forms.fields._current-password')
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            <button type="submit" class="btn btn-danger">Delete account</button>
        </x-slot>
    </x-modals._form-modal>
@endpush
