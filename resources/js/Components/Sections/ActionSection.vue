<template>
    <div class="row">
        <section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </section-title>

        <div class="mt-6 md:mt-0 offset-lg-1 col-md-8 col-lg-7">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script>
    import SectionTitle from './SectionTitle';

    export default {
        components: {
            SectionTitle,
        }
    }
</script>
