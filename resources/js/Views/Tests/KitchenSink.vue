<template>
    <section-content class="min-h-screen h-screen bg-gray-700">
        <div class="row justify-center py-16">
            <div class="col-12 col-md-8 col-lg-6">
                <card>
                    <template #content>
                        <div class="flex items-center justify-center">
                            <app-button @clicked="toggleModal" mode="primary">Click here!</app-button>

                            <modal :has-actions="true" :show="open" @close="open = false">
                                <template #content>
                                    Yolo Mofo!
                                </template>

                                <template #actions>
                                    <app-button @clicked="toggleModal" mode="secondary">Close</app-button>
                                </template>
                            </modal>
                        </div>
                    </template>
                </card>
            </div>
        </div>
    </section-content>
</template>

<script>
    import Modal from './Modal';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        components: {
            Modal,
            AppButton
        },

        data() {
            return {
                open: false
            }
        },

        methods: {
            toggleModal() {
                this.open = ! this.open;
            }
        }
    }
</script>
