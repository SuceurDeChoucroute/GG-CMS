import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Dashboard from '../components/admin/pages/Dashboard.vue'

import Players from '../components/admin/pages/players/Players.vue'
import PlayerShow from '../components/admin/pages/players/PlayerShow.vue'
import PlayerCreate from '../components/admin/pages/players/PlayerCreate.vue'

import Teams from '../components/admin/pages/teams/Teams.vue'
import TeamShow from '../components/admin/pages/teams/TeamShow.vue'
import TeamCreate from '../components/admin/pages/teams/TeamCreate.vue'

import Games from '../components/admin/pages/games/Games.vue'
import GameShow from '../components/admin/pages/games/GameShow.vue'
import GameCreate from '../components/admin/pages/games/GameCreate.vue'

import RankCreate from '../components/admin/pages/games/RankCreate.vue'
import RankEdit from '../components/admin/pages/games/RankEdit.vue'

import Tournaments from '../components/admin/pages/tournaments/Tournaments.vue'
import TournamentShow from '../components/admin/pages/tournaments/TournamentShow.vue'
import TournamentCreate from '../components/admin/pages/tournaments/TournamentCreate.vue'

import Posts from '../components/admin/pages/posts/Posts.vue'
import PostCreate from '../components/admin/pages/posts/PostCreate.vue'
import PostEdit from '../components/admin/pages/posts/PostEdit.vue'
import PostShow from '../components/admin/pages/posts/PostShow.vue'

import Partners from '../components/admin/pages/partners/Partners.vue'
import PartnerCreate from '../components/admin/pages/partners/PartnerCreate.vue'
import PartnerEdit from '../components/admin/pages/partners/PartnerEdit.vue'

import Rules from '../components/admin/pages/rules/Rules.vue'

const routes = [
    // Dashboard
    { name: "index", path: '/', component: Dashboard },

    // Players
    { name: "players", path: '/players', component: Players },
    { name: "player.show", path: '/player/show/:id', component: PlayerShow },
    { name: "player.create", path: '/player/create', component: PlayerCreate },

    // Teams
    { name: "teams", path: '/teams', component: Teams },
    { name: "team.show", path: '/team/show/:id', component: TeamShow },
    { name: "team.create", path: '/team/create', component: TeamCreate },

    // Games
    { name: "games", path: '/games', component: Games },
    { name: "game.show", path: '/game/show/:id', component: GameShow },
    { name: "game.create", path: '/game/create', component: GameCreate },

    // Ranks
    { name: "rank.create", path: '/game/show/:id/rank/create', component: RankCreate },
    { name: "rank.edit", path: '/game/show/:game/rank/edit/:rank', component: RankEdit },

    // Tournaments
    { name: "tournaments", path: '/tournaments', component: Tournaments },
    { name: "tournament.show", path: '/tournament/show/:id', component: TournamentShow },
    { name: "tournament.create", path: '/tournament/create', component: TournamentCreate },

    // Posts
    { name: "posts", path: '/posts', component: Posts },
    { name: "post.create", path: '/post/create', component: PostCreate },
    { name: "post.edit", path: '/post/edit/:id', component: PostEdit },
    { name: "post.show", path: '/post/show/:id', component: PostShow },

    // Rules
    { name: "rules", path: '/rules', component: Rules },

    { name: "partners", path: '/partners', component: Partners },
    { name: "partner.create", path: '/partner/create', component: PartnerCreate },
    { name: "partner.edit", path: '/partner/edit/:id', component: PartnerEdit },

];
const router = new Router({
    routes
});

router.beforeEach((to, from, next) => {
    if (auth.check()) {
        let user

        axios.get('/api/user')
        .then(response => {
            user = response.data
            if (user.admin) {
                next();
            }
        })
        .catch(response => {
            window.location.href = '/';
        })
        
        return;
    }
    else {
        window.location.href = '/';
    }
})

export default router;