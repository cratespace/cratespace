<template>
    <div class="mt-2" v-show="message">
        <p class="font-semibold text-xs text-red-500 m-0 p-0">{{ message }}</p>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
