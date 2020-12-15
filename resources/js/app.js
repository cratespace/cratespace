require('./bootstrap');

import Vue from 'vue';
import PortalVue from 'portal-vue';
import Form from './Utilities/Form';

window.Form = Form;

Vue.config.productionTip = false;

/**
 * Mixins.
 */
Vue.mixin({ methods: { route } });

/**
 * Plugins.
 */
Vue.use(PortalVue);

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
Vue.component('card', require('./Components/Cards/Card').default);
Vue.component('logo', require('./Components/Logos/Logo').default);
Vue.component('logo-light', require('./Components/Logos/LogoLight').default);

/**
 * Auth Views
 */
Vue.component('sign-out', require('./Views/Auth/SignOut').default);
Vue.component('sign-up', require('./Views/Auth/SignUp').default);
Vue.component('sign-in', require('./Views/Auth/SignIn').default);
Vue.component('tfa-challenge', require('./Views/Auth/TwoFactorAuthenticationChallenge').default);
Vue.component('reset-password-request', require('./Views/Auth/ResetPasswordRequest').default);
Vue.component('reset-password', require('./Views/Auth/ResetPassword').default);
Vue.component('kitchen-sink', require('./Views/Tests/KitchenSink').default);

/**
 * Profile Views
 */
Vue.component('show-profile', require('./Views/Profile/Show').default);

/**
 * API Token Views
 */
Vue.component('api-token-management', require('./Views/API/ApiTokenManagement').default);

/**
 * Vue Instance.
 */
const app = new Vue({
    el: '#app',
});
