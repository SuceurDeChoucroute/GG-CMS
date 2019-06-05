import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

// Home
import SiteHome from '../components/site/pages/SiteHome.vue'

// Auth
import Login from '../components/site/pages/auth/Login.vue'
import Register from '../components/site/pages/auth/Register.vue'

// Rules
import Rules from '../components/site/pages/rules/SiteRules.vue'

// Teams
import Teams from '../components/site/pages/teams/SiteTeams.vue'
import TeamShow from '../components/site/pages/teams/SiteTeamShow.vue'

// Players
import PlayerParameters from '../components/site/pages/players/SitePlayerParameters.vue'

const routes = [
    // Home
    { name: "home", path: '/', component: SiteHome },

    // Auth
    { name: "login", path: '/login', component: Login },
    { name: "register", path: '/register', component: Register },

    // Rules
    { name: "rules", path: '/rules', component: Rules },

    // Teams
    { name: "teams", path: '/teams', component: Teams },
    { name: "team.show", path: '/teams/:id', component: TeamShow },

    // Players
    { name: "player.parameters", path: '/parameters/:id', component: PlayerParameters },

];

export default new Router({
    routes,
});