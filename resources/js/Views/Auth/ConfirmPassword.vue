<template>
    <auth-layout>
        <template #title>
            <div>
                <div>
                    <logo-text :title="config('app.name')" classes="h-10 w-auto"></logo-text>
                </div>

                <h4 class="mt-10 font-semibold text-xl text-gray-800">Confirm your password</h4>

                <p class="mt-3 font-normal text-base text-gray-500">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>
            </div>
        </template>

        <template #form>
            <form @submit.prevent="confirm" class="w-full">
                <div class="mt-6 block">
                    <app-input type="password" v-model="form.password" :error="form.errors.password" label="Password" placeholder="cattleFarmer1576@!" required></app-input>
                </div>

                <div class="mt-6 block">
                    <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Confirm <span class="ml-1">&rarr;</span>
                    </app-button>
                </div>
            </form>
        </template>
    </auth-layout>
</template>

<script>
import AuthLayout from '@/Views/Layouts/AuthLayout';
import LogoText from '@/Views/Components/Logos/LogoText';
import AppLink from '@/Views/Components/Base/Link';
import AppInput from '@/Views/Components/Inputs/Input';
import AppButton from '@/Views/Components/Buttons/Button';
import Checkbox from '@/Views/Components/Inputs/Checkbox';

export default {
    components: {
        AuthLayout,
        LogoText,
        AppLink,
        AppInput,
        AppButton,
        Checkbox
    },

    data() {
        return {
            form: this.$inertia.form({
                password: null,
            }),
        }
    },

    methods: {
        confirm() {
            this.form.post(this.route('password.confirm'), {
                onFinish: () => this.form.reset(),
            })
        }
    }
};
</script>
