<template>
    <aside class="main-sidebar">
        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">
                    <img :src="user.avatar" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p v-if="user"> {{ user.pseudo }} </p>
                </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
                <li v-for="(nav, key) in navs" :key="key" :class="{ 'active':nav.name.includes($route.name.split('.')[0]) }">
                    <router-link :to="{ name: nav.name }">
                        <i class="fas" :class="nav.icon"></i>
                        <span> {{ nav.title }} </span> 
                    </router-link>
                </li>
            </ul>
        </section>
    </aside>
</template>

<script>
export default {    
    data() {
        return {
            authenticated: auth.check(),
            user: null,
            navs: [
                { name: 'index', icon: 'fa-tachometer-alt', title: 'Tableau de bord'},
                { name: 'players', icon: 'fa-users', title: 'Joueurs'},
                { name: 'teams', icon: 'fa-user-friends', title: 'Equipes'},
                { name: 'games', icon: 'fa-gamepad', title: 'Jeux'},
                { name: 'tournaments', icon: 'fa-trophy', title: 'Tournois'},
                { name: 'posts', icon: 'fa-newspaper', title: 'Articles'},
                { name: 'rules', icon: 'fa-align-left', title: 'Règlement'},
                { name: 'partners', icon: 'fa-handshake', title: 'Partenaires'},
            ]
        }
    },

    methods: {
        getUser() {
            axios.get('/api/user')
            .then(response => {
                this.user = response.data
            })
        },
    },

    mounted() {
        if (this.authenticated) {
            this.user = this.getUser()
        }
    }
}
</script>

<style>

</style>
