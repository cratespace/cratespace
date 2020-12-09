<template>
    <action-section>
        <template #title>
            Two factor authentication
        </template>

        <template #description>
            Add additional security to your account using two factor authentication.
        </template>

        <template #content>
            <h3 class="text-base font-medium text-gray-800" v-if="twoFactorEnabled">
                You have enabled two factor authentication.
            </h3>

            <h3 class="text-base font-medium text-gray-800" v-else>
                You have not enabled two factor authentication.
            </h3>

            <div class="mt-3 max-w-xl">
                <p class="text-sm text-gray-600">
                    When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl">
                        <p class="text-sm text-gray-600">
                            Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.
                        </p>
                    </div>

                    <div class="mt-4 p-4 w-56 bg-white" v-html="qrCode">
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0">
                    <div class="mt-4 max-w-xl">
                        <p class="text-sm text-gray-600">
                            Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
                        </p>
                    </div>

                    <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 text-gray-700 rounded-lg">
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div v-if="! twoFactorEnabled">
                    <confirm-password-modal name="enableTwoFactorAuthenticationPasswordConfrimModal" @confirmed="enableTwoFactorAuthentication">
                        <app-button mode="primary" type="button" :class="{ 'opacity-25': enabling }" :loading="enabling">
                            Enable
                        </app-button>
                    </confirm-password-modal>
                </div>

                <div v-else>
                    <confirm-password-modal name="regenerateRecoveryCodesPasswordConfrimModal" @confirmed="regenerateRecoveryCodes">
                        <app-button class="mr-3" mode="secondary" v-if="recoveryCodes.length > 0">
                            Regenerate recovery codes
                        </app-button>
                    </confirm-password-modal>

                    <confirm-password-modal name="showRecoveryCodesPasswordConfrimModal" @confirmed="showRecoveryCodes">
                        <app-button class="mr-3" mode="secondary" v-if="recoveryCodes.length == 0">
                            Show recovery codes
                        </app-button>
                    </confirm-password-modal>

                    <confirm-password-modal name="disableTwoFactorAuthenticationPasswordConfrimModal" @confirmed="disableTwoFactorAuthentication">
                        <app-button mode="primary" type="button" :class="{ 'opacity-25': disabling }" :loading="disabling">
                            Disable
                        </app-button>
                    </confirm-password-modal>
                </div>


            </div>
        </template>
    </action-section>
</template>

<script>
    import ActionSection from '@/Components/Sections/ActionSection';
    import AppButton from '@/Components/Buttons/Button';
    import ConfirmPasswordModal from '@/Components/Modals/ConfirmPasswordModal';

    export default {
        props: ['user'],

        components: {
            ActionSection,
            AppButton,
            ConfirmPasswordModal,
        },

        computed: {
            twoFactorEnabled() {
                return ! this.enabling && this.tfaEnabled;
            }
        },

        data() {
            return {
                enabling: false,
                disabling: false,
                tfaEnabled: this.user.two_factor_enabled,
                qrCode: null,
                recoveryCodes: [],
            }
        },

        methods: {
            async enableTwoFactorAuthentication() {
                this.enabling = true;

                await axios.post('/user/tfa')
                    .then(() => {
                        this.showQrCode();
                        this.showRecoveryCodes();

                        this.enabling = false;
                        this.tfaEnabled = true;
                    });
            },

            showQrCode() {
                return axios.get('/user/tfa-qr-code')
                        .then(response => {
                            this.qrCode = response.data.svg;
                        });
            },

            showRecoveryCodes() {
                return axios.get('/user/tfa-recovery-codes')
                        .then(response => {
                            this.recoveryCodes = response.data;
                        });
            },

            regenerateRecoveryCodes() {
                axios.post('/user/tfa-recovery-codes')
                    .then(response => {
                        this.showRecoveryCodes();
                    });
            },

            async disableTwoFactorAuthentication() {
                this.disabling = true

                await axios.delete('/user/tfa')
                    .then(() => {
                        this.disabling = false;
                        this.tfaEnabled = false;
                    });
            },
        }
    }
</script>
