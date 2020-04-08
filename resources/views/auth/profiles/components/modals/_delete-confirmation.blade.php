<div class="modal fade" id="deleteModal{{ $user->username }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $user->username }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered rounded-lg" role="document">
        <div class="modal-content rounded-lg">
            <div class="modal-body">
                <div class="flex">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    <div class="ml-4">
                        <h5 class="modal-title text-lg font-medium text-gray-800 mb-3" id="deleteModal{{ $user->username }}Label">Delete Account</h5>

                        <p class="text-sm text-gray-600 mb-2 max-w-sm">
                            Are you sure you want to delete your account? All of your data will be permanantly removed. This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-gray-100">
                <span class="mt-3 flex w-full rounded-lg shadow-sm sm:mt-0 sm:w-auto">
                    <button type="button" class="inline-flex justify-center w-full rounded-lg border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm" data-dismiss="modal">
                        Cancel
                    </button>
                </span>

                <form class="flex w-full rounded-lg shadow-sm sm:ml-2 sm:w-auto mt-0" method="POST" action="{{ route('users.destroy', $user) }}">
                    @csrf

                    @method('DELETE')

                    <button type="submit" class="inline-flex justify-center w-full rounded-lg border border-transparent px-4 py-2 bg-red-600 text-base font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
