<template>
    <form enctype="multipart/form-data">
        <div>
            <div class="row items-center">
                <div class="col-md-4 mb-6 flex items-center">
                    <image-upload-form :image="business.image" route="/" label="Logo"></image-upload-form>
                </div>

                <div class="col-md-8 mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Bussiness name</span>

                        <input type="text" name="name" id="name" class="form-input mt-1 block w-full" required v-model="form.name" placeholder="Example Company">
                    </label>

                    <div v-show="form.errors.has('business')" class="mt-2" role="alert">
                        <span class="text-xs text-red-500 font-semibold">{{ form.errors.get('business') }}</span>
                    </div>


                    <span class="text-xs text-gray-600">Your business name may be used on invoices and receipts. Please make sure it's correct.</span>
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
                                        <span class="text-gray-500">
                                            +94
                                        </span>
                                    </div>

                                <input id="phone" name="phone" type="tel" class="form-input block w-full px-12" required v-model="form.phone" placeholder="76 589 5534" />
                            </div>
                        </div>

                        <div class="mt-2" v-show="form.errors.has('phone')" role="alert">
                            <span class="text-xs text-red-500 font-semibold">{{ form.errors.get('phone') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Email</span>

                        <input type="email" name="email" id="email" v-model="form.email" pattern=".+@.+\..+" class="form-input mt-1 block w-full" required placeholder="example@company.com">
                    </label>

                    <div v-show="form.errors.has('email')" class="mt-2" role="alert">
                        <span class="text-xs text-red-500 font-semibold">{{ form.errors.get('email') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block">
                    <span class="text-gray-700 text-sm font-semibold">Description</span>

                    <textarea name="description" id="description" v-model="form.description" rows="5" placeholder="Tell us a little about your business" class="form-input block w-full mt-1"></textarea>
                </label>

                <div class="mt-2" v-show="form.errors.has('description')" role="alert">
                    <span class="text-xs text-red-500 font-semibold">{{ form.errors.get('description') }}</span>
                </div>
            </div>

            <div class="mt-6 py-3 flex items-center justify-end">
                <span v-show="form.successful" class="flex items-center">
                    <span class="text-green-500">&check;</span>

                    <span class="ml-1 text-xs text-gray-500 font-medium">Changes saved</span>
                </span>

                <button class="btn btn-primary inline-flex items-center ml-5" @click.prevent="update(route, form)">
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
    import helpers from '../../support/helpers';
    import Forms from '../../app/Forms';

    export default {
        props: ['business', 'route'],

        components: {
            ImageUploadForm
        },

        mixins: [helpers],

        data() {
            return {
                form: new Forms({
                    name: this.business.name,
                    email: this.business.email,
                    phone: this.business.phone,
                })
            }
        }
    }
</script>
