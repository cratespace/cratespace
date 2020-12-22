<template>
    <form @submit.prevent="signIn" class="w-full">
        <div class="mt-6 block">
            <app-input type="email" v-model="form.email" autofocus :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
        </div>

        <div class="mt-6 block">
            <app-input type="password" v-model="form.password" :error="form.error('password')" label="Password" placeholder="cattleFarmer1576@!"></app-input>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div>
                <checkbox id="remember" v-model="form.remember" label="Stay signed in"></checkbox>
            </div>

            <div class="text-sm leading-5">
                <app-link :href="route('password.request')">Forgot your password?</app-link>
            </div>
        </div>

        <div class="mt-6 block">
            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Sign in <span class="ml-1">&rarr;</span>
            </app-button>
        </div>
    </form>
</template>

<script>
    import AppLink from '@/Components/Base/Link';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';
    import Checkbox from '@/Components/Inputs/Checkbox';

    export default {
        components: {
            AppLink,
            AppInput,
            AppButton,
            Checkbox
        },

        data() {
            return {
                form: this.$form({
                    email: null,
                    password: null,
                    remember: true
                })
            }
        },

        methods: {
            signIn() {
                this.form.post(route('signin'))
                    .then(response => {
                        if (! this.form.hasErrors()) {
                            window.location = this.redirectTo(response);
                        }
                    });
            },

            redirectTo(response) {
                if (response.data.tfa === true) {
                    return route('tfa.signin');
                }

                return route('home');
            }
        }
    }
</script>
