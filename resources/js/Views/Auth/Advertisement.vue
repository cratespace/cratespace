<template>
    <div class="bg-gradient-to-br from-blue-700 to-blue-500 h-full p-10">
        <div>
            <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
        </div>

        <div class="mt-6 max-w-xs">
            <div>
                <h6 class="text-white font-bold">Get started quickly</h6>

                <p class="text-blue-100 text-sm">
                    Integrate with developer-friendly APIs or choose low-code or pre-built solutions.
                </p>
            </div>

            <div class="mt-6">
                <h6 class="text-white font-bold">Support any business model</h6>

                <p class="text-blue-100 text-sm">
                    E-commerce, subscriptions, SaaS platforms, marketplaces, and more – all within a unified platform.
                </p>
            </div>

            <div class="mt-6">
                <h6 class="text-white font-bold">Join millions of businesses</h6>

                <p class="text-blue-100 text-sm">
                    Stripe is trusted by ambitious startups and enterprises of every size.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import Logo from '@/Views/Components/Logos/Logo';

export default {
    components: {
        Logo
    },
}
</script>
