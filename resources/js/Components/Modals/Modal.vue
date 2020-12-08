<template>
    <div class="modal fade" :id="name" :aria-labelledby="name + 'Label'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog rounded-xl overflow-hidden">
            <div class="relative modal-content p-0">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['name']
    }
</script>
