import './components';
import 'popper.js';
import 'jquery';
import 'bootstrap';
import 'moment';

import _ from 'lodash';
import axios from 'axios';
import Vue from 'vue';
import PortalVue from 'portal-vue';
import Form from './Utilities/Form';

window.Form = Form;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

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
 * Vue Instance.
 */
const app = new Vue({
    el: '#app',
});
