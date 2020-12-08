<template>
    <form-section @submitted="updatePassword()">
        <template #title>
            Update password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="row">
                <div class="mt-6 col-12 col-lg-7">
                    <div>
                        <app-input type="password" v-model="form.password" :error="form.error('password')" label="New password" placeholder="hunterKiller739@3$"></app-input>
                    </div>

                    <div class="mt-6">
                        <app-input type="password" v-model="form.password_confirmation" :error="form.error('password_confirmation')" label="Retype new password" placeholder="hunterKiller739@3$"></app-input>
                    </div>

                    <div class="mt-6">
                        <app-input type="password" v-model="form.current_password" :error="form.error('current_password')" label="Current password" placeholder="cattleFarmer1576@!"></app-input>

                        <div class="mt-2">
                            <span class="font-medium text-xs text-gray-500">
                                Type in your current password to confirm it's really you making the change.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 col-12 col-lg-5">
                    <span class="font-medium text-xs text-gray-500">
                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </span>
                </div>
            </div>
        </template>

        <template #actions>
            <action-message :on="form.successful" class="mr-4">
                Changes saved.
            </action-message>

            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Update password
            </app-button>
        </template>
    </form-section>
</template>

<script>
    import Forms from '@/Utilities/Forms';
    import FormSection from '@/Components/Sections/FormSection';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';
    import ActionMessage from '@/Components/Alerts/ActionMessage';

    export default {
        components: {
            FormSection,
            AppInput,
            AppButton,
            ActionMessage,
        },

        data() {
            return {
                form: new Forms({
                    current_password: null,
                    password: null,
                    password_confirmation: null,
                })
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'))
                    .then(response => {
                        if (response.status === 200) {
                            this.form.reset();
                        }
                    });
            }
        }
    }
</script>
