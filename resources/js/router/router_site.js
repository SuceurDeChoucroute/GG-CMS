import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Home from '../components/site/pages/Home.vue'
import Login from '../components/site/pages/auth/Login.vue'
import Register from '../components/site/pages/auth/Register.vue'


const routes = [
    // Home
    { name: "home", path: '/', component: Home },

    // Auth
    { name: "login", path: '/login', component: Login },
    { name: "register", path: '/register', component: Register },

];

export default new Router({
    routes,
});