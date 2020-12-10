require('./bootstrap');

window.Vue = require('vue');

window.Form = require('./Utilities/Form').default;

Vue.config.productionTip = false;

/**
 * Mixins.
 */
Vue.mixin({ methods: { route } });

/**
 * Components.
 */
Vue.component('app-link', require('./Components/Base/Link').default);
Vue.component('navbar', require('./Components/Navbars/Navbar').default);
Vue.component('navbar-link', require('./Components/Navbars/NavbarLink').default);
Vue.component('dropdown', require('./Components/Dropdowns/Dropdown').default);
Vue.component('dropdown-link', require('./Components/Dropdowns/DropdownLink').default);
Vue.component('dropdown-divider', require('./Components/Dropdowns/DropdownDivider').default);
Vue.component('app-section', require('./Components/Sections/Section').default);
Vue.component('main-section', require('./Components/Sections/MainSection').default);
Vue.component('section-header', require('./Components/Sections/SectionHeader').default);
Vue.component('section-title', require('./Components/Sections/SectionTitle').default);
Vue.component('section-content', require('./Components/Sections/SectionContent').default);
Vue.component('section-border', require('./Components/Sections/SectionBorder').default);
Vue.component('section-footer', require('./Components/Sections/SectionFooter').default);
Vue.component('logo', require('./Components/Logos/Logo').default);
Vue.component('inline-svg', require('./Components/Icons/InlineSvg').default);
Vue.component('logo-light', require('./Components/Logos/LogoLight').default);

/**
 * Views.
 */

// Auth Views
Vue.component('sign-up', require('./Views/Auth/SignUp').default);
Vue.component('sign-in', require('./Views/Auth/SignIn').default);
Vue.component('tfa-challenge', require('./Views/Auth/TwoFactorAuthenticationChallenge').default);
Vue.component('reset-password-request', require('./Views/Auth/ResetPasswordRequest').default);
Vue.component('reset-password', require('./Views/Auth/ResetPassword').default);

// Profile Views
Vue.component('delete-user-form', require('./Views/Profile/DeleteUserForm').default);
Vue.component('signout-other-browser-sessions-form', require('./Views/Profile/SignoutOtherBrowserSessionsForm').default);
Vue.component('tfa-form', require('./Views/Profile/TwoFactorAuthenticationForm').default);
Vue.component('update-password-form', require('./Views/Profile/UpdatePasswordForm').default);
Vue.component('update-profile-information-form', require('./Views/Profile/UpdateProfileInformationForm').default);
Vue.component('api-token-management', require('./Views/API/ApiTokenManagement').default);

const app = new Vue({
    el: '#app',

    methods: {
        signOut() {
            axios.post(route('signout')).then(() => window.location = '/');
        }
    }
});
