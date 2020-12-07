require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false;

/**
 * Mixins.
 */
Vue.mixin({ methods: { route } });

/**
 * Components.
 */
Vue.component('app-input', require('./Components/Inputs/Input').default);
Vue.component('navbar', require('./Components/Navbars/Navbar').default);
Vue.component('navbar-link', require('./Components/Navbars/NavbarLink').default);
Vue.component('dropdown', require('./Components/Dropdowns/Dropdown').default);
Vue.component('dropdown-link', require('./Components/Dropdowns/DropdownLink').default);

/**
 * Misc.
 */
Vue.component('sign-out', require('./Components/Misc/SignOut').default);

/**
 * Views.
 */
Vue.component('sign-in', require('./Views/SignIn').default);
Vue.component('sign-up', require('./Views/SignUp').default);
Vue.component('reset-password-request', require('./Views/ResetPasswordRequest').default);

const app = new Vue({
    el: '#app',

    methods: {
        signOut() {
            axios.post(route('signout')).then(response => window.location = '/');
        }
    }
});
