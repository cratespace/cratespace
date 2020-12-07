require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false;

Vue.mixin({ methods: { route } });

Vue.component('navbar', require('./Components/Navbars/Navbar').default);
Vue.component('navbar-link', require('./Components/Navbars/NavbarLink').default);
Vue.component('dropdown', require('./Components/Dropdowns/Dropdown').default);
Vue.component('dropdown-link', require('./Components/Dropdowns/DropdownLink').default);
Vue.component('sign-out', require('./Components/Misc/SignOut').default);

const app = new Vue({
    el: '#app',
});
