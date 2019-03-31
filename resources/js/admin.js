require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import FlashMessage from '@smartweb/vue-flash-message';

Vue.use(VueRouter);

const flashConfig = {
    time: 5000,
}
Vue.use(FlashMessage, flashConfig);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import AdminDashboard from './components/admin/pages/AdminDashboard.vue'
import AdminPlayers from './components/admin/pages/AdminPlayers.vue'

const routes = [
    { 
        name: "index",
        path: '/', 
        component: AdminDashboard 
    },
    { 
        name: "players",
        path: '/players',
        component: AdminPlayers 
    },
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

const app = new Vue({
    router,
}).$mount('#app')
