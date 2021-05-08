<template>
    <guest-layout>
        <div>
            <!-- Content -->
        </div>
    </guest-layout>
</template>

<script>
import GuestLayout from '@/Views/Layouts/GuestLayout';
import AppLink from '@/Views/Components/Base/Link';

export default {
    components: {
        GuestLayout,
        AppLink,
    },

    props: ['order'],
};
</script>
