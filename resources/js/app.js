require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import router from './router/router_site.js';
import auth from './auth/auth.js';

window.Vue = require('vue');
window.auth = auth;
Vue.use(BootstrapVue)

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    router,
}).$mount('#app')
