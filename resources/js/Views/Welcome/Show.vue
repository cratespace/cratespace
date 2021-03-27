<template>
    <guest-layout>
        <div>
            <filter-form></filter-form>
        </div>
    </guest-layout>
</template>

<script>
import FilterForm from './FilterForm';
import GuestLayout from '@/Views/Layouts/GuestLayout';
import AppLink from '@/Views/Components/Base/Link';

export default {
    components: {
        GuestLayout,
        FilterForm,
        AppLink,
    }
};
</script>
