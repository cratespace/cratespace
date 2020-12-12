<template>
    <form @submit.prevent="signOut">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        methods: {
            signOut() {
                axios.post(route('signout')).then(() => window.location = '/');
            }
        }
    }
</script>
