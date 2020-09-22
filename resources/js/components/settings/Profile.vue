<template>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <div class="mb-8">
                <image-upload-form :image="user.profile_photo_url" route="/" label="Photo"></image-upload-form>
            </div>

            <div class="row">
                <div class="col-md-7 mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Full name</span>

                        <input name="name" id="name" type="text" v-model="name" class="form-input mt-1 block w-full" required placeholder="John Doe">
                    </label>

                    <div v-show="errors.has('name')" class="mt-2" role="alert">
                        <span class="text-xs text-red-500 font-semibold">{{ errors.get('name') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Email</span>

                        <input type="email" name="email" id="email" v-model="email" pattern=".+@.+\..+" class="form-input mt-1 block w-full" required placeholder="john.doe@example.com">
                    </label>

                    <div v-show="errors.has('email')" class="mt-2" role="alert">
                        <span class="text-xs text-red-500 font-semibold">{{ errors.get('email') }}</span>
                    </div>

                    <span class="text-sm block mt-2" role="alert">
                        We will never share your email with anyone else.
                    </span>
                </div>

                <div class="col-md-6 mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Username</span>

                        <input name="username" id="username" type="text" v-model="username" class="form-input mt-1 block w-full" required placeholder="JohnDoe">
                    </label>

                    <div v-show="errors.has('username')" class="mt-2" role="alert">
                        <span class="text-xs text-red-500 font-semibold">{{ errors.get('username') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-6">
                    <div>
                        <div>
                            <label for="phone" class="block">
                                <span class="text-gray-700 text-sm font-semibold">Phone</span>
                            </label>

                            <div class="mt-1 relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                    <span class="text-gray-500">+94</span>
                                </div>

                                <input id="phone" name="phone" v-model="phone" type="tel" class="form-input block w-full px-12" required placeholder="76 589 5534" />
                            </div>
                        </div>

                        <div v-show="errors.has('phone')" class="mt-2" role="alert">
                            <span class="text-xs text-red-500 font-semibold">{{ errors.get('phone') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 py-3 flex items-center justify-end">
                <span v-show="successful" class="flex items-center">
                    <span class="text-green-500">&check;</span>

                    <span class="ml-1 text-xs text-gray-500 font-medium">Changes saved</span>
                </span>

                <button class="btn btn-primary inline-flex items-center ml-5" @click.prevent="update()">
                    <svg v-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span>Save</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import ImageUploadForm from '../ImageUploadForm';
    import Errors from '../../app/Errors.js';

    export default {
        props: ['user', 'route'],

        components: {
            ImageUploadForm
        },

        data() {
            return {
                name: this.user.name,
                username: this.user.username,
                email: this.user.email,
                phone: this.user.phone,
                errors: new Errors(),
                successful: false,
                loading: false
            }
        },

        methods: {
            update() {
                this.loading = true;

                axios.put(this.route, {
                        name: this.name,
                        username: this.username,
                        email: this.email,
                        phone: this.phone,
                    })
                    .then(response => {
                        console.log(response);

                        if (response.status >= 200) {
                            this.flashSuccess();
                        }
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });

                    this.loading = false;
            },

            flashSuccess() {
                this.successful = true;

                setTimeout(() => {
                    this.successful = false;
                }, 3000);
            }
        }
    }
</script>
