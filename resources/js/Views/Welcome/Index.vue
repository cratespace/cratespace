<template>
    <guest-layout>
        <div>
            <filter-form></filter-form>

            <product-grid :spaces="spaces.data"></product-grid>

            <pagination :links="spaces.links"></pagination>
        </div>
    </guest-layout>
</template>

<script>
import FilterForm from './FilterForm';
import ProductGrid from './ProductGrid';
import GuestLayout from '@/Views/Layouts/GuestLayout';
import AppLink from '@/Views/Components/Base/Link';
import Pagination from '@/Views/Components/Pagination/Pagination';

export default {
    components: {
        GuestLayout,
        FilterForm,
        ProductGrid,
        AppLink,
        Pagination
    },

    props: ['spaces'],
};
</script>
