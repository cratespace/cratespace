import "@/Plugins";
import "./components";

import axios from "axios";
import Vue from "vue";
import PortalVue from "portal-vue";
import Form from "@thavarshan/preflight-js";
import { config } from "@/Config";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;

Vue.config.productionTip = false;

/**
 * Mixins.
 */
Vue.mixin({ methods: { route, config } });

/**
 * Plugins.
 */
Vue.use(PortalVue);
Vue.use(Form);

/**
 * Vue Instance.
 */
const app = new Vue({
    el: "#app",

    methods: {
        signout() {
            axios.post(route("signout")).then(() => (window.location = "/"));
        }
    }
});
