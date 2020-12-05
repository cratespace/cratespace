require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false;

Vue.component('sign-out', require('./components/SignOut.vue').default);

const app = new Vue({
    el: '#app',
});
