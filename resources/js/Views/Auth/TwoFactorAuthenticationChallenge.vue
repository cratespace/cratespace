<template>
    <form @submit.prevent="authenticate()" class="w-full">
        <div class="mt-6 mb-4 text-sm text-gray-600" v-show="! recovery">
            Please confirm access to your account by entering the authentication code provided by your authenticator application.
        </div>

        <div class="mt-6 mb-4 text-sm text-gray-600" v-show="recovery">
            Please confirm access to your account by entering one of your emergency recovery codes.
        </div>

        <div v-if="! form.hasErrors()">
            <div v-show="! recovery" class="mt-6 block">
                <app-input type="text" v-model="form.code" label="Code" placeholder="746 598" inputmode="numeric" ref="code" autocomplete="one-time-code"></app-input>
            </div>

            <div v-show="recovery" class="mt-6 block">
                <app-input type="text" v-model="form.recovery_code" label="Recovery Code" placeholder="s2VYxQQLHv-8HkO5z6CPn" inputmode="numeric" ref="recovery_code" autocomplete="one-time-code"></app-input>
            </div>
        </div>

        <div v-else>
            <div class="mt-2">
                <p class="font-semibold text-xs text-red-500 m-0 p-0">{{ showError() }}</p>
            </div>
        </div>

        <div class="mt-6 block">
            <app-button type="button" mode="secondary" class="mr-3" v-show="! recovery" @clicked="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                Use a recovery code
            </app-button>

            <app-button type="button" mode="secondary" class="mr-3" v-show="recovery" @clicked="recovery = false; $nextTick(() => { $refs.code.focus() })">
                Use an authentication code
            </app-button>

            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Sign in <span class="ml-1">&rarr;</span>
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
                recovery: false,

                form: new Form({
                    code: null,
                    recovery_code: null,
                })
            }
        },

        methods: {
            async authenticate() {
                await this.form.post('/tfa-challenge')
                    .then(() => {
                        if (! this.form.hasErrors()) {
                            window.location = route('home');
                        } else {
                            setTimeout(() => window.location = route('signin'), 3000);
                        }
                    });
            },

            showError() {
                if (this.form.hasError('code')) {
                    return this.form.error('code');
                }

                return this.form.error('recovery_code');
            }
        }
    }
</script>
