<template>
    <div>
        <form-section @submitted="createToken">
            <template #title>
                Create API token
            </template>

            <template #description>
                API tokens allow third-party services to authenticate with our application on your behalf.
            </template>

            <template #form>
                <div class="row">
                    <div class="col-lg-8">
                        <app-input type="text" v-model="createForm.name" :error="createForm.error('name')" label="Token name" placeholder="my-awesome-app"></app-input>
                    </div>
                </div>

                <div class="mt-6" v-if="availablePermissions.length > 0">
                    <h6 class="text-gray-600 text-sm font-semibold">Permissions</h6>

                    <hr class="my-3">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center cursor-pointer">
                                <input class="form-checkbox rounded text-blue-500 bg-white border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out" v-model="createForm.permissions" :value="permission" type="checkbox"/>

                                <span class="ml-2 text-sm font-medium leading-5">
                                    <span>{{ permission }}</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <action-message :on="createForm.recentlySuccessful" class="mr-4">
                    Created. <span class="ml-1">&check;</span>
                </action-message>

                <app-button type="submit" mode="primary" :class="{ 'opacity-25': createForm.processing }" :loading="createForm.processing">
                    Create token
                </app-button>
            </template>
        </form-section>

        <dialog-modal :has-actions="true" :show="displayingToken" @close="displayingToken = false">
            <template #title>
                API Token
            </template>

            <template #content>
                <div class="max-w-xl">
                    <p class="text-gray-600">
                        Please copy your new API token. For your security, it won't be shown again.
                    </p>
                </div>

                <div class="mt-6">
                    <div class="bg-gray-100 px-4 py-2 rounded-lg font-mono text-sm text-gray-800" v-if="displayableToken">
                        {{ displayableToken }}
                    </div>
                </div>
            </template>

            <template #actions>
                <app-button @clicked="displayingToken = false" mode="secondary" data-dismiss="modal">
                    Close
                </app-button>
            </template>
        </dialog-modal>

        <div v-if="tokens.length > 0">
            <section-border></section-border>

            <action-section>
                <template #title>
                    Manage API tokens
                </template>

                <template #description>
                    You may delete any of your existing tokens if they are no longer needed.
                </template>

                <template #content>
                    <div class="rounded-xl overflow-hidden mb-4" v-for="token in tokens" :key="token.id">
                        <div class="px-4 py-5 sm:px-6 bg-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-700">{{ token.name }}</span>
                                </div>

                                <div class="flex items-center">
                                    <div class="text-xs text-gray-500" v-if="token.last_used_at">
                                        Last used {{ fromNow(token.last_used_at) }}
                                    </div>

                                    <button class="cursor-pointer ml-6 text-blue-500 underline-none outline-none focus:outline-none"
                                        @click="managePermissions(token)"
                                        v-if="availablePermissions.length > 0">
                                        <span class="font-medium text-xs">Permissions</span>
                                    </button>

                                    <button class="cursor-pointer ml-6 text-red-500 focus:outline-none" @click="confirmTokenDeletion(token)">
                                        <span class="font-medium text-xs">Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </action-section>

            <dialog-modal :has-actions="true" :show="managingPermissionsFor" @close="managingPermissionsFor = false">
                <template #title>
                    API token permissions
                </template>

                <template #content>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center cursor-pointer">
                                <input class="form-checkbox rounded text-blue-500 bg-white border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out" v-model="updateForm.permissions" :value="permission" type="checkbox"/>

                                <span class="ml-2 text-sm font-medium leading-5">
                                    <span>{{ permission }}</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <app-button class="mr-3" @clicked="managingPermissionsFor = null" mode="secondary" data-dismiss="modal">
                        Cancel
                    </app-button>

                    <app-button mode="primary" type="button" @clicked="updateToken" :class="{ 'opacity-25': updateForm.processing }" :loading="updateForm.processing">
                        Save changes
                    </app-button>
                </template>
            </dialog-modal>

            <dialog-modal :has-actions="true" :show="tokenBeingDeleted" @close="tokenBeingDeleted = false">
                <template #title>
                    Delete API token
                </template>

                <template #content>
                    <div class="max-w-xl">
                        <p class="text-gray-600">
                            Are you sure you would like to delete this API token?
                        </p>
                    </div>
                </template>

                <template #actions>
                    <app-button class="mr-3" @clicked="tokenBeingDeleted = null" mode="secondary" data-dismiss="modal">
                        Cancel
                    </app-button>

                    <app-button mode="danger" type="button" @clicked="deleteToken" :class="{ 'opacity-25': deleteForm.processing }" :loading="deleteForm.processing">
                        Delete
                    </app-button>
                </template>
            </dialog-modal>
        </div>
    </div>
</template>

<script>
    import { fromNow } from '@/Utilities/helpers';
    import Checkbox from '@/Components/Inputs/Checkbox';
    import DialogModal from '@/Components/Modals/DialogModal';
    import FormSection from '@/Components/Sections/FormSection';
    import ActionSection from '@/Components/Sections/ActionSection';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';
    import ActionMessage from '@/Components/Alerts/ActionMessage';
    import SectionBorder from '@/Components/Sections/SectionBorder';

    export default {
        props: [
            'availablePermissions',
            'defaultPermissions',
        ],

        components: {
            Checkbox,
            AppInput,
            AppButton,
            FormSection,
            ActionMessage,
            ActionSection,
            DialogModal,
        },

        data() {
            return {
                tokens: [],

                createForm: new Form({
                    name: null,
                    permissions: this.defaultPermissions
                }, {
                    resetOnSuccess: true,
                }),

                updateForm: new Form({
                    name: null,
                    permissions: []
                }, {
                    resetOnSuccess: false,
                }),

                deleteForm: new Form({}),

                displayableToken: null,
                displayingToken: false,
                managingPermissionsFor: null,
                tokenBeingDeleted: null,
            }
        },

        mounted() {
            this.fetchApiData();
        },

        methods: {
            fetchApiData() {
                axios.get(route('api-tokens.index'))
                    .then(response => {
                        this.tokens = response.data.tokens;
                    });
            },

            createToken() {
                this.createForm.post(route('api-tokens.store'))
                    .then((response) => {
                        if (! this.createForm.hasErrors()) {
                            this.displayableToken = response.data.token;

                            this.fetchApiData();

                            this.displayingToken = true;
                        }
                    });
            },

            managePermissions(token) {
                this.updateForm.permissions = token.abilities;

                this.managingPermissionsFor = token;
            },

            updateToken() {
                this.updateForm.put(route('api-tokens.update', this.managingPermissionsFor))
                    .then(() => {
                        this.managingPermissionsFor = null;

                        this.fetchApiData();
                    });
            },

            confirmTokenDeletion(token) {
                this.tokenBeingDeleted = token;
            },

            deleteToken() {
                this.deleteForm.delete(route('api-tokens.destroy', this.tokenBeingDeleted))
                    .then(() => {
                        this.tokenBeingDeleted = null;

                        this.fetchApiData();
                    });
            },

            fromNow,
        }
    }
</script>
