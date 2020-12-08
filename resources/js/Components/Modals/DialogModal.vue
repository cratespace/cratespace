<template>
    <modal :name="name">
        <card>
            <template #content>
                <div class="modal-header p-0">
                    <h5 class="modal-title text-gray-800 font-semibold text-lg" :id="name + 'Label'">
                        <slot name="title"></slot>
                    </h5>
                </div>

                <div class="modal-body mt-3 p-0">
                    <slot name="content"></slot>
                </div>
            </template>

            <template #actions>
                <slot name="actions"></slot>
            </template>
        </card>
    </modal>
</template>

<script>
    import Modal from '@/Components/Modals/Modal';
    import Card from '@/Components/Cards/Card';

    export default {
        props: ['name'],

        components: {
            Card,
            Modal,
        },
    }
</script>

