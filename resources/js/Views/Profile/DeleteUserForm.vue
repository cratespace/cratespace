<template>
    <action-section>
        <template #title>
            Delete account
        </template>

        <template #description>
            Permanently delete your account.
        </template>

        <template #content>
            <div class="max-w-xl">
                <p class="text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                </p>
            </div>

            <div class="mt-5">
                <app-button mode="danger" @clicked="confirmUserDeletion" type="button">
                    Delete account
                </app-button>
            </div>

            <dialog-modal name="confirmUserDeletionModal">
                <template #title>
                    Delete account
                </template>

                <template #content>
                    <div class="max-w-xl">
                        <p class="text-gray-600">
                            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                        </p>
                    </div>

                    <div class="mt-6">
                        <app-input type="password" v-model="form.password" :error="form.error('password')" ref="password" label="Password" placeholder="cattleFarmer1576@!"></app-input>
                    </div>
                </template>

                <template #actions>
                    <app-button class="mr-3" @clicked="confirmingUserDeletion = false" mode="secondary" data-dismiss="modal">
                        Cancel
                    </app-button>

                    <app-button mode="danger" type="button" @clicked="deleteUser" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Delete account
                    </app-button>
                </template>
            </dialog-modal>
        </template>
    </action-section>
</template>

<script>
    import ActionSection from '@/Components/Sections/ActionSection';
    import DialogModal from '@/Components/Modals/DialogModal';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        components: {
            ActionSection,
            AppButton,
            AppInput,
            DialogModal,
        },

        data() {
            return {
                confirmingUserDeletion: false,

                form: new Form({
                    password: null
                }, {
                    resetOnSuccess: false,
                }),
            }
        },

        methods: {
            confirmUserDeletion() {
                this.form.password = null;

                this.confirmingUserDeletion = true;

                $('#confirmUserDeletionModal').modal('show');

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            async deleteUser() {
                await this.form.delete(route('user.destroy'))
                    .then(() => {
                        if (! this.form.hasErrors()) {
                            this.confirmingUserDeletion = false;

                            $('#confirmUserDeletionModal').modal('hide');

                            window.location = '/';
                        }
                    });
            },
        }
    }
</script>
