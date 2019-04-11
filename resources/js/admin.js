require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import FlashMessage from '@smartweb/vue-flash-message';
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use(VueRouter);
Vue.use(CKEditor);

const flashConfig = {
    time: 5000,
    strategy: "single",
}
Vue.use(FlashMessage, flashConfig);
axios.defaults.baseURL = process.env.MIX_APP_URL;

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

import AdminTournaments from './components/admin/pages/tournaments/AdminTournaments.vue'
import AdminTournamentShow from './components/admin/pages/tournaments/AdminTournamentShow.vue'
import AdminTournamentCreate from './components/admin/pages/tournaments/AdminTournamentCreate.vue'

import AdminPosts from './components/admin/pages/posts/AdminPosts.vue'
import AdminPostCreate from './components/admin/pages/posts/AdminPostCreate.vue'
import AdminPostEdit from './components/admin/pages/posts/AdminPostEdit.vue'

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

    // Tournaments
    { name: "tournaments", path: '/tournaments', component: AdminTournaments },
    { name: "tournament.show", path: '/tournament/show/:id', component: AdminTournamentShow },
    { name: "tournament.create", path: '/tournament/create', component: AdminTournamentCreate },

    // Posts
    { name: "posts", path: '/posts', component: AdminPosts },
    { name: "post.create", path: '/post/create', component: AdminPostCreate },
    { name: "post.edit", path: '/post/edit/:id', component: AdminPostEdit },
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

const app = new Vue({
    router,
}).$mount('#app')
