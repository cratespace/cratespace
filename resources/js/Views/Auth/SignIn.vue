<template>
    <form @submit.prevent="signIn()" class="w-full">
        <div class="mt-6 block">
            <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
        </div>

        <div class="mt-6 block">
            <app-input type="password" v-model="form.password" :error="form.error('password')" label="Password" placeholder="cattleFarmer1576@!"></app-input>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div>
                <label for="remember" class="flex items-center cursor-pointer">
                    <input id="remember" class="form-checkbox rounded text-blue-500 bg-white border border-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out" v-model="form.remember" type="checkbox"/>

                    <span class="ml-2 text-sm font-medium leading-5">
                        <span>Stay signed in</span>
                    </span>
                </label>
            </div>

            <div class="text-sm leading-5">
                <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" :href="route('password.request')">
                    Forgot your password?
                </a>
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
    import Forms from '@/Utilities/Forms';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        components: {
            AppInput,
            AppButton,
        },

        data() {
            return {
                form: new Forms({
                    email: null,
                    password: null,
                    remember: true
                })
            }
        },

        methods: {
            async signIn() {
                await this.form.post(route('signin'))
                    .then(response => {
                        this.form.reset();

                        window.location = route('home');
                    });
            }
        }
    }
</script>
