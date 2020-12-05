<template>
    <a @click.prevent="signOut()" href="#" class="dropdown-item leading-6 rounded-lg block text-gray-600 hover:text-gray-600 focus:text-white active:text-white hover:bg-gray-100 focus:bg-blue-500 active:bg-blue-600 focus:outline-none transition ease-in-out duration-150">
        <span class="font-semibold text-sm">Sign out</span>
    </a>
</template>

<script>
    export default {
        props: ['route'],

        methods: {
            signOut() {
                axios.post(this.route)
                    .then(response => {
                        if (response.status === 204) {
                            window.location.href = '/'
                        }
                    });
            }
        }
    }
</script>
