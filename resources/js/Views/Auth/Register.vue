<template>
    <auth-layout>
        <template #title>
            <div>
                <div>
                    <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                </div>

                <h4 class="mt-6 font-semibold text-xl text-gray-800">Create new account</h4>

                <p class="mt-3 font-normal text-base text-gray-500">
                    If you are a business and wish to sell your freight spaces on Cratespace, you will have to request for an invite and cannot create an account directly.
                </p>
            </div>
        </template>

        <template #form>
            <form @submit.prevent="register" class="w-full">
                <div class="block">
                    <app-input type="text" v-model="form.name" :error="form.errors.name" label="Full name" placeholder="Johnathan Doeford" required autofocus></app-input>
                </div>

                <div class="mt-6 block">
                    <app-input type="tel" v-model="form.phone" :error="form.errors.phone" label="Phone number" placeholder="0765895534" required></app-input>
                </div>

                <div class="mt-6 block">
                    <app-input type="email" v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john.doe@example.com" required></app-input>
                </div>

                <div class="mt-6 block">
                    <app-input type="password" v-model="form.password" :error="form.errors.password" label="Password" placeholder="cattleFarmer1576@!" required></app-input>
                </div>

                <div class="mt-6">
                    <p class="font-normal text-xs text-gray-400">
                        By clicking "Create account", you agree to Cratespace's <app-link href="#">Terms of Use</app-link> and acknowledge you have read the <app-link href="#">Privacy Policy</app-link>.
                    </p>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <app-button href="#" :link="true" mode="secondary">
                        Request invite
                    </app-button>

                    <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Create account <span class="ml-1">&rarr;</span>
                    </app-button>
                </div>

                <div class="mt-6">
                    <p>
                        Already have an account? <app-link :href="route('login')">Sign in</app-link>
                    </p>
                </div>
            </form>
        </template>
    </auth-layout>
</template>

<script>
import AuthLayout from '@/Views/Layouts/AuthLayout';
import Logo from '@/Views/Components/Logos/Logo';
import AppLink from '@/Views/Components/Base/Link';
import AppInput from '@/Views/Components/Inputs/Input';
import AppButton from '@/Views/Components/Buttons/Button';
import Checkbox from '@/Views/Components/Inputs/Checkbox';

export default {
    components: {
        AuthLayout,
        Logo,
        AppLink,
        AppInput,
        AppButton,
        Checkbox
    },

    data() {
        return {
            form: this.$inertia.form({
                name: null,
                email: null,
                phone: null,
                password: null,
                type: 'customer',
                remember: true
            }),
        }
    },

    methods: {
        register() {
            this.form.post(this.route('register'), {
                preserveScroll: true,
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
};
</script>
