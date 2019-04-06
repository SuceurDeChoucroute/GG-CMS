require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import FlashMessage from '@smartweb/vue-flash-message';

Vue.use(VueRouter);

const flashConfig = {
    time: 5000,
    strategy: "single",
}
Vue.use(FlashMessage, flashConfig);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import AdminDashboard from './components/admin/pages/AdminDashboard.vue'

import AdminPlayers from './components/admin/pages/players/AdminPlayers.vue'
import AdminPlayerShow from './components/admin/pages/players/AdminPlayerShow.vue'
import AdminPlayerCreate from './components/admin/pages/players/AdminPlayerCreate.vue'

import AdminTeams from './components/admin/pages/teams/AdminTeams.vue'
import AdminTeamShow from './components/admin/pages/teams/AdminTeamShow.vue'
import AdminTeamCreate from './components/admin/pages/teams/AdminTeamCreate.vue'

import AdminGames from './components/admin/pages/games/AdminGames.vue'
import AdminGameShow from './components/admin/pages/games/AdminGameShow.vue'
import AdminGameCreate from './components/admin/pages/games/AdminGameCreate.vue'

const routes = [
    // Dashboard
    { name: "index", path: '/', component: AdminDashboard },

    // Players
    { name: "players", path: '/players',component: AdminPlayers },
    { name: "player.show", path: '/player/show/:id', component: AdminPlayerShow },
    { name: "player.create", path: '/player/create', component: AdminPlayerCreate },

    // Teams
    { name: "teams", path: '/teams', component: AdminTeams },
    { name: "team.show", path: '/team/show/:id', component: AdminTeamShow },
    { name: "team.create", path: '/team/create', component: AdminTeamCreate },

    // Games
    { name: "games", path: '/games', component: AdminGames },
    { name: "game.show", path: '/game/show/:id', component: AdminGameShow },
    { name: "game.create", path: '/game/create', component: AdminGameCreate },
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

const app = new Vue({
    router,
}).$mount('#app')
