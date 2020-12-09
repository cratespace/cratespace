<template>
    <form-section @submitted="updateProfileInformation()">
        <template #title>
            Profile information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <div class="row">
                <div class="mt-6 col-lg-6">
                    <app-input type="text" v-model="form.name" :error="form.error('name')" label="Full name" placeholder="Johnathan Doe"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="text" v-model="form.username" :error="form.error('username')" label="Username" placeholder="JohnTheFarmer"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="tel" v-model="form.phone" :error="form.error('phone')" label="Phone number" placeholder="701897361"></app-input>
                </div>
            </div>
        </template>

        <template #actions>
            <action-message :on="form.recentlySuccessful" class="mr-4">
                Changes saved. <span class="ml-1">&check;</span>
            </action-message>

            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Save changes
            </app-button>
        </template>
    </form-section>
</template>

<script>
    import FormSection from '@/Components/Sections/FormSection';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';
    import ActionMessage from '@/Components/Alerts/ActionMessage';

    export default {
        props: ['user'],

        components: {
            FormSection,
            AppInput,
            AppButton,
            ActionMessage,
        },

        data() {
            return {
                form: new Form({
                    name: this.user.name,
                    username: this.user.username,
                    email: this.user.email,
                    phone: this.user.phone,
                }, {
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            updateProfileInformation() {
                this.form.put(route('profile.update'));
            }
        }
    }
</script>
