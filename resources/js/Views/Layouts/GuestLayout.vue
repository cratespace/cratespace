<template>
    <div class="min-h-screen min-w-full overflow-x-hidden">
        <!-- Header Area -->
        <header>
            <navbar class="bg-white border-b border-gray-100">
                <template #logo>
                    <logo-text classes="h-5 w-auto text-blue-500" :title="config('app.name')"></logo-text>
                </template>

                <template #linksleft>
                    <navbar-link :href="route('welcome')" :active="route().current('welcome')" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        Listing
                    </navbar-link>

                    <navbar-link href="#" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        About
                    </navbar-link>

                    <navbar-link href="#" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        Services
                    </navbar-link>

                    <navbar-link href="#" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        Support
                    </navbar-link>
                </template>

                <template v-if="! $page.props.user" #linksright>
                    <navbar-link :href="route('login')" :active="route().current('login')" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        Sign in
                    </navbar-link>

                    <app-button :link="true" :href="route('register')" mode="primary">
                        <span>
                            Sign up <span class="ml-1">&rarr;</span>
                        </span>
                    </app-button>
                </template>

                <template #linksright v-else>
                    <navbar-link :href="route('home')" :active="route().current('home')" class="text-gray-500 bg-tranparent hover:bg-tranparent focus:bg-tranparent">
                        <span>
                            Dashboard <span class="ml-1">&rarr;</span>
                        </span>
                    </navbar-link>
                </template>
            </navbar>
        </header>

        <!-- Main Content Area -->
        <main class="py-6 bg-gray-50" role="main">
            <div class="container mx-auto px-4 sm:px-6">
                <slot></slot>
            </div>
        </main>

        <!-- Footer Area -->
        <footer>
            <div class="container mx-auto px-4 sm:px-6">
                <div class="py-16 flex items-center justify-center">
                    <p class="text-center">
                        <span class="text-gray-500 text-xs">{{ copyright }}</span>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import LogoText from '@/Views/Components/Logos/LogoText';
import Navbar from '@/Views/Components/Navbars/Navbar';
import AppButton from '@/Views/Components/Buttons/Button';
import NavbarLink from '@/Views/Components/Navbars/NavbarLink';

export default {
    components: {
        Navbar,
        NavbarLink,
        LogoText,
        AppButton
    },

    data() {
        return {
            copyright: `© ${new Date().getFullYear()} ${this.config('app.name')}. All rights reserved.`,
        };
    },
};
</script>
