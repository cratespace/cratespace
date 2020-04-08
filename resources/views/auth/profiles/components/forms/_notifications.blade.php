<div class="row mb-6">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4 class="text-xl font-semibold">
                Notifications
            </h4>

            <p class="text-sm text-gray-600 max-w-sm">
                We'll always let you know about important changes, but you pick what else you want to hear about.
            </p>
        </div>
    </div>

    <div class="col-lg-8">
        <form class="shadow rounded-lg overflow-hidden" action="{{ route('users.notifications', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white px-4 py-5 sm:px-6">
                <div class="mb-6">
                    <h5 class="text-lg font-medium text-gray-800 mb-3">
                        Email preferences
                    </h5>
                </div>

                <div>
                    <div class="flex mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="notifications_email[]" id="notifications-email-new-order" value="new-order" class="form-checkbox h-5 w-5 mr-4 text-indigo-500" {{ in_array('new-order', $user->settings['notifications_email']) ? 'checked' : null }}>

                            <div>
                                <div class="font-semibold">New order placed</div>

                                <div class="text-gray-600 text-sm">
                                    Get notified when a customer places a new order.
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="flex mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="notifications_email[]" id="notifications-email-cancel-order" value="cancel-order" class="form-checkbox h-5 w-5 mr-4 text-indigo-500" {{ in_array('cancel-order', $user->settings['notifications_email']) ? 'checked' : null }}>

                            <div>
                                <div class="font-semibold">Order cancel request</div>

                                <div class="text-gray-600 text-sm">
                                    Get notified when a customer request a cancelation of their order.
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="flex mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="notifications_email[]" id="notifications-email-newsletter" value="newsletter" class="form-checkbox h-5 w-5 mr-4 text-indigo-500" {{ in_array('newsletter', $user->settings['notifications_email']) ? 'checked' : null }}>

                            <div>
                                <div class="font-semibold">{{ config('app.name') }} news and product updates</div>

                                <div class="text-gray-600 text-sm">
                                    We’ll occasionally contact you with the latest news and happenings from {{ config('app.name') }}.
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-lg font-medium text-gray-800">
                        Mobile preferences
                    </h5>

                    <p class="text-sm text-gray-600 max-w-sm">
                        These are delivered via {{ config('app.name') }} app.
                    </p>
                </div>

                <div>
                    <label class="flex items-center mb-6">
                        <input type="radio" class="form-radio text-indigo-500 h-5 w-5" name="notifications_mobile" value="everything"
                        {{ $user->settings['notifications_mobile'] == 'everything' ? 'checked' : null }}>
                        <span class="ml-4 font-semibold">Everything</span>
                    </label>

                    <label class="flex items-center mb-6">
                        <input type="radio" class="form-radio text-indigo-500 h-5 w-5" name="notifications_mobile" value="emails"
                        {{ $user->settings['notifications_mobile'] == 'emails' ? 'checked' : null }}>
                        <span class="ml-4 font-semibold">Same as email</span>
                    </label>

                    <label class="flex items-center">
                        <input type="radio" class="form-radio text-indigo-500 h-5 w-5" name="notifications_mobile" value="none"
                        {{ $user->settings['notifications_mobile'] == 'none' ? 'checked' : null }}>
                        <span class="ml-4 font-semibold">No push notifications</span>
                    </label>
                </div>
            </div>

            <div class="bg-gray-100 px-4 py-5 sm:px-6">
                <div class="flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
