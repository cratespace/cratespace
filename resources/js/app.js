require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false;

// Vue.component("profile", require("./components/settings/Profile.vue").default);

const app = new Vue({
    el: '#app',
});
