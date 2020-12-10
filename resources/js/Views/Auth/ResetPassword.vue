<template>
    <form @submit.prevent="resetPassword">
        <div class="mt-6">
            <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
        </div>

        <div class="mt-6">
            <app-input type="password" v-model="form.password" :error="form.error('password')" label="New password" placeholder="battleCattleFarmer1589@!"></app-input>
        </div>

        <div class="mt-6">
            <app-input type="password" v-model="form.password_confirmation" :error="form.error('password_confirmation')" label="Confirm new password" placeholder="battleCattleFarmer1589@!"></app-input>
        </div>

        <div class="mt-6">
            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing || this.message }" :loading="form.processing || form.recentlySuccessful">
                Reset password
            </app-button>
        </div>

        <div class="mt-6" v-show="message">
            <span class="font-medium text-xs text-green-500" role="alert" v-text="message"></span>
        </div>
    </form>
</template>

<script>
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        props: ['token'],

        components: {
            AppInput,
            AppButton,
        },

        data() {
            return {
                form: new Form({
                    token: this.token,
                    email: null,
                    password: null,
                    password_confirmation: null,
                }),

                message: null
            }
        },

        methods: {
            resetPassword() {
                this.form.post(route('password.update'))
                    .then(response => {
                        if (! this.form.hasErrors()) {
                            this.message = response.data.message;

                            setTimeout(() => {
                                window.location = route('signin');
                            }, 5000);
                        }
                    });
            }
        }
    }
</script>
