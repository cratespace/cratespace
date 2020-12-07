<template>
    <navbar-link class="text-gray-300" @click.prevent="signOut" href="#">Sign out</navbar-link>
</template>

<script>
    export default {
        methods: {
            signOut() {
                alert('Worked!');
                // axios.post(route('signout').url()).then(response => window.location = '/');
            }
        }
    }
</script>
