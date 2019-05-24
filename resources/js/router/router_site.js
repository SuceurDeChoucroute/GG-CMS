import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Home from '../components/site/pages/Home.vue'
import Login from '../components/site/pages/auth/Login.vue'


const routes = [
    // Home
    { name: "home", path: '/', component: Home },

    { name: "login", path: '/login', component: Login },

];

export default new Router({
    routes,
});