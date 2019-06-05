require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'
import router from './router/router_site.js';
import auth from './auth/auth.js';
import VueNoty from 'vuejs-noty'
import 'vuejs-noty/dist/vuejs-noty.css'

window.Vue = require('vue');
window.auth = auth;
Vue.use(BootstrapVue)

Vue.use(VueNoty, {
    timeout: 3000,
    theme: "bootstrap-v4",
    progressBar: true,
    layout: 'topRight'
})

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    router,
}).$mount('#app')
