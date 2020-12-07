<template>
    <div class="mt-1" v-show="message">
        <p class="font-semibold text-xs text-red-500 m-0 p-0">{{ message }}</p>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
