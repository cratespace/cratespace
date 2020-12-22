<template>
    <form @submit.prevent="signUp" class="w-full">
        <div class="row">
            <div class="mt-6 col-12 col-md-6">
                <app-input type="text" v-model="form.name" :error="form.error('name')" label="Full name" placeholder="Johnathan Doe"></app-input>
            </div>

            <div class="mt-6 col-12 col-md-6">
                <app-input type="text" v-model="form.business" :error="form.error('business')" label="Business name" placeholder="Johnathan Doe"></app-input>
            </div>
        </div>

        <div class="row">
            <div class="mt-6 col-12 col-md-6">
                <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
            </div>

            <div class="mt-6 col-12 col-md-6">
                <app-input type="tel" v-model="form.phone" :error="form.error('phone')" label="Phone number" placeholder="701897361"></app-input>
            </div>
        </div>

        <div class="row">
            <div class="mt-6 col-12 col-md-6">
                <app-input type="password" v-model="form.password" :error="form.error('password')" label="Password" placeholder="cattleFarmer1576@!"></app-input>
            </div>

            <div class="mt-6 col-12 col-md-6">
                <app-input type="password" v-model="form.password_confirmation" :error="form.error('password_confirmation')" label="Confirm password" placeholder="cattleFarmer1576@!"></app-input>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-xs text-gray-600 leading-5">
                By clicking Submit, you confirm you have read and agreed to <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="/terms">Cratespace General Terms and Conditions</a> and <a class="text-blue-500 hover:text-blue-600 focus:text-blue-600 active:text-gray-600 transition ease-in-out duration-150" href="/privacy">Privacy Policy</a>.
            </p>
        </div>

        <div class="mt-6 block">
            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Create account <span class="ml-1">&rarr;</span>
            </app-button>
        </div>
    </form>
</template>

<script>
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        components: {
            AppInput,
            AppButton,
        },

        data() {
            return {
                form: this.$form({
                    name: null,
                    business: null,
                    email: null,
                    phone: null,
                    password: null,
                    password_confirmation: null,
                })
            }
        },

        methods: {
            signUp() {
                this.form.post(route('signup'))
                    .then(() => {
                        if (! this.form.hasErrors()) {
                            window.location = route('home');
                        }
                    });
            }
        }
    }
</script>
