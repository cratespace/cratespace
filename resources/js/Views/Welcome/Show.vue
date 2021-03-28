<template>
    <guest-layout>
        <div>
            <filter-form></filter-form>

            <product-grid></product-grid>
        </div>
    </guest-layout>
</template>

<script>
import FilterForm from './FilterForm';
import ProductGrid from './ProductGrid';
import GuestLayout from '@/Views/Layouts/GuestLayout';
import AppLink from '@/Views/Components/Base/Link';

export default {
    components: {
        GuestLayout,
        FilterForm,
        ProductGrid,
        AppLink,
    }
};
</script>
