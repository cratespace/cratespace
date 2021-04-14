<template>
    <auth-layout>
        <template #left>
            <div class="hidden md:block rounded-xl overflow-hidden h-full">
                <div class="px-4 sm:px-6 py-5 bg-gradient-to-br from-blue-700 to-blue-500 h-full">
                    <div>
                        <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                    </div>

                    <div class="mt-6">
                        <div>
                            <h6 class="text-white font-bold">Get started quickly</h6>

                            <p class="text-blue-100 text-sm">
                                Integrate with developer-friendly APIs or choose low-code or pre-built solutions.
                            </p>
                        </div>

                        <div class="mt-6">
                            <h6 class="text-white font-bold">Support any business model</h6>

                            <p class="text-blue-100 text-sm">
                                E-commerce, subscriptions, SaaS platforms, marketplaces, and more – all within a unified platform.
                            </p>
                        </div>

                        <div class="mt-6">
                            <h6 class="text-white font-bold">Join millions of businesses</h6>

                            <p class="text-blue-100 text-sm">
                                Stripe is trusted by ambitious startups and enterprises of every size.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #right>
            <div>
                <div>
                    <div class="mb-6 block md:hidden">
                        <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                    </div>

                    <div>
                        <h4 class="font-semibold text-xl text-gray-800">Create your Cratespace account</h4>

                        <p class="mt-3 font-normal text-base text-gray-500 max-w-md">
                            If you are a business and wish to sell your freight spaces on Cratespace, you will have to request for an invite and cannot create an account directly.
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <form @submit.prevent="register" class="w-full lg:grid lg:grid-cols-12 gap-6">
                        <div class="mt-6 lg:mt-0 lg:col-span-8">
                            <app-input type="text" v-model="form.name" :error="form.errors.name" label="Full name" placeholder="Johnathan Doeford" required autofocus></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="tel" v-model="form.phone" :error="form.errors.phone" label="Phone number" placeholder="0765895534" required></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="email" v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john.doe@example.com" required></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="password" v-model="form.password" :error="form.errors.password" label="Password" placeholder="cattleFarmer1576@!" required></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" label="Confirm password" placeholder="cattleFarmer1576@!" required></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 col-span-12">
                            <p class="font-normal text-xs text-gray-400 max-w-sm">
                                By clicking "Create account", you agree to Cratespace's <app-link href="#">Terms of Use</app-link> and acknowledge you have read the <app-link href="#">Privacy Policy</app-link>.
                            </p>
                        </div>

                        <div class="mt-6 lg:mt-0 col-span-12 flex items-center justify-start">
                            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                                Create account <span class="ml-1">&rarr;</span>
                            </app-button>

                            <app-button href="#" :link="true" mode="secondary" class="ml-3">
                                Request invite
                            </app-button>
                        </div>

                        <div class="mt-6 lg:mt-0 col-span-full">
                            <p>
                                Already have an account? <app-link :href="route('login')">Sign in</app-link>
                            </p>
                        </div>
                    </form>
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
                name: null,
                email: null,
                phone: null,
                password: null,
                password_confirmation: null,
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
