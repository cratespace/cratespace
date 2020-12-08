<template>
    <button @click="$emit('clicked')" :disabled="loading" class="inline-block shadow items-center whitespace-no-wrap px-4 py-0 leading-9 border border-transparent rounded-xl  focus:outline-none focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150" :class="colors">
        <span class="font-semibold text-sm">
            <slot></slot>
        </span>
    </button>
</template>

<script>
    export default {
        props: ['mode', 'loading'],

        computed: {
            colors() {
                if (this.mode === 'primary') {
                    return 'text-white hover:text-white focus:text-white active:text-white bg-blue-500 hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-600';
                } else if (this.mode === 'danger') {
                    return 'text-white hover:text-white focus:text-white active:text-white bg-red-500 hover:bg-red-600 focus:bg-red-600 active:bg-red-600';
                } else {
                    return 'text-gray-600 hover:text-gray-600 focus:text-gray-600 active:text-gray-600 bg-white hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 border border-gray-100';
                }
            }
        }
    }
</script>
