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
Vue.component('navbar', require('./Components/Navbars/Navbar').default);
Vue.component('navbar-link', require('./Components/Navbars/NavbarLink').default);
Vue.component('dropdown', require('./Components/Dropdowns/Dropdown').default);
Vue.component('dropdown-link', require('./Components/Dropdowns/DropdownLink').default);
Vue.component('section-loader', require('./Components/Sections/SectionLoader').default);

/**
 * Misc.
 */

/**
 * Views.
 */

// Auth Views
Vue.component('sign-in', require('./Views/Auth/SignIn').default);
Vue.component('tfa-challenge', require('./Views/Auth/TwoFactorAuthenticationChallenge').default);
Vue.component('sign-up', require('./Views/Auth/SignUp').default);
Vue.component('reset-password-request', require('./Views/Auth/ResetPasswordRequest').default);

// Profile Views
Vue.component('delete-user-form', require('./Views/Profile/DeleteUserForm').default);
Vue.component('signout-other-browser-sessions-form', require('./Views/Profile/SignoutOtherBrowserSessionsForm').default);
Vue.component('tfa-form', require('./Views/Profile/TwoFactorAuthenticationForm').default);
Vue.component('update-password-form', require('./Views/Profile/UpdatePasswordForm').default);
Vue.component('update-profile-information-form', require('./Views/Profile/UpdateProfileInformationForm').default);

const app = new Vue({
    el: '#app',

    methods: {
        signOut() {
            axios.post(route('signout'))
                .then(response => window.location = '/');
        }
    }
});
