<template>
    <action-section>
        <template #title>
            Browser sessions
        </template>

        <template #description>
            Manage and sign out your active sessions on other browsers and devices.
        </template>

        <template #content>
            <div class="max-w-xl">
                <p class="text-sm text-gray-600">
                    If necessary, you may sign out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
                </p>
            </div>

            <div class="mt-6" v-if="sessions.length > 0">
                <div class="flex items-center mb-4" v-for="(session, i) in sessions" :key="i">
                    <div>
                        <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 text-gray-600" v-if="session.agent.is_desktop">
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-gray-600" v-else>
                            <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                        </svg>
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600">
                            {{ session.agent.platform }} - {{ session.agent.browser }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-600">
                                {{ session.ip_address }},

                                <span class="text-green-500 font-semibold" v-if="session.is_current_device">This device</span>
                                <span v-else>Last active {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-6">
                <app-button mode="primary" @click.native="confirmSignout">
                    Sign out other browser sessions
                </app-button>

                <action-message :on="form.recentlySuccessful" class="ml-4">
                    Done. <span class="ml-1">&check;</span>
                </action-message>
            </div>

            <dialog-modal has-actions name="confirmSignoutModal">
                <template #title>
                    Sign out other browser sessions
                </template>

                <template #content>
                    <div class="max-w-xl">
                        <p class="text-gray-600">
                            Please enter your password to confirm you would like to sign out of your other browser sessions across all of your devices.
                        </p>
                    </div>

                    <div class="mt-6">
                        <app-input type="password" v-model="form.password" :error="form.error('password')" ref="password" label="Password" placeholder="cattleFarmer1576@!"></app-input>
                    </div>
                </template>

                <template #actions>
                    <app-button class="mr-3" mode="secondary" data-dismiss="modal" @clicked="confirmingSignout = false">
                        Cancel
                    </app-button>

                    <app-button mode="primary" type="button" @clicked="signoutOtherBrowserSessions" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Sign out other browser sessions
                    </app-button>
                </template>
            </dialog-modal>
        </template>
    </action-section>
</template>

<script>
    import ActionSection from '@/Components/Sections/ActionSection';
    import ConfirmPasswordModal from '@/Components/Modals/ConfirmPasswordModal';
    import AppButton from '@/Components/Buttons/Button';
    import AppInput from '@/Components/Inputs/Input';
    import ActionMessage from '@/Components/Alerts/ActionMessage';
    import DialogModal from '@/Components/Modals/DialogModal';

    export default {
        props: ['sessions'],

        components: {
            ActionSection,
            AppButton,
            AppInput,
            ActionMessage,
            ConfirmPasswordModal,
            DialogModal,
        },

        data() {
            return {
                confirmingSignout: false,

                form: new Form({
                    password: null,
                }),
            }
        },

        methods: {
            confirmSignout() {
                this.form.password = null

                $('#confirmSignoutModal').modal('show');

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250);
            },

            signoutOtherBrowserSessions() {
                this.form.delete(route('other-browser-sessions.destroy'))
                    .then(() => {
                        if (! this.form.hasErrors()) {
                            $('#confirmSignoutModal').modal('hide');
                        }
                    });
            },
        },
    }
</script>
