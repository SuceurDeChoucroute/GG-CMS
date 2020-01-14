require('./bootstrap');

window.Vue = require('vue');

import router from './router/router_admin.js';
import FlashMessage from '@smartweb/vue-flash-message';
import CKEditor from '@ckeditor/ckeditor5-vue';
import auth from './auth/auth.js';
import VueApexCharts from 'vue-apexcharts'
import AdminDataTable from './components/admin/layouts/AdminDataTable.vue'

Vue.use(CKEditor);
Vue.use(AdminDataTable);
Vue.component('apexchart', VueApexCharts)
window.auth = auth;

const flashConfig = {
    time: 5000,
    strategy: "single",
}
Vue.use(FlashMessage, flashConfig);

axios.defaults.baseURL = process.env.MIX_APP_URL;

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    router,
}).$mount('#app')
