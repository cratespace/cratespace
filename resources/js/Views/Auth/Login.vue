<template>
    <auth-layout>
        <template #left>
            <div>
                <div>
                    <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                </div>

                <h4 class="mt-6 font-semibold text-xl text-gray-800">Login to your account</h4>

                <p class="mt-3 font-normal text-base text-gray-500">
                    Thank you for getting back to us. Let's access your account and get you started.
                </p>
            </div>

            <div class="mt-6">
                <form @submit.prevent="login" class="w-full">
                    <div class="block">
                        <app-input type="email" v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john.doe@example.com" required autofocus></app-input>
                    </div>

                    <div class="mt-6 block">
                        <app-input type="password" v-model="form.password" :error="form.errors.password" label="Password" placeholder="cattleFarmer1576@!" required></app-input>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div>
                            <checkbox id="remember" v-model:checked="form.remember" label="Stay signed in"></checkbox>
                        </div>

                        <div class="text-sm leading-5">
                            <app-link :href="route('password.email')">Forgot your password?</app-link>
                        </div>
                    </div>

                    <div class="mt-6 block">
                        <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                            Sign in <span class="ml-1">&rarr;</span>
                        </app-button>
                    </div>

                    <div class="mt-6">
                        <p>
                            Don't have an account yet? <app-link :href="route('register')">Create account</app-link>.
                        </p>
                    </div>
                </form>
            </div>
        </template>

        <template #right>
            <div class="hidden md:block rounded-xl overflow-hidden h-full">
                <div class="px-4 sm:px-6 py-5 bg-gradient-to-tl from-blue-700 to-blue-500 h-full">
                    <div class="flex items-end justify-end h-full">
                        <div class="lg:mb-6 lg:mr-6">
                            <h3 class="text-right text-2xl text-white font-light max-w-sm">
                                Linking you to your <span class="font-bold">customers</span>
                            </h3>

                            <h6 class="mt-6 text-right text-base text-white max-w-sm">
                                Buy and sell on the platform with the largest network of active Logistics services.
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
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
                email: null,
                password: null,
                remember: true
            }),
        }
    },

    methods: {
        login() {
            this.form.post('/login', {
                preserveScroll: true,
                onFinish: () => this.form.reset('password'),
            });
        }
    }
};
</script>
