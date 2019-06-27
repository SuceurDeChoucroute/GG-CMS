<template>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <router-link :to="{name: 'home'}" class="navbar-brand">
            Home
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDropdown" aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDropdown">
            <ul class="navbar-nav">
                <li class="nav-item" v-for="(nav, key) in navs" :key="key" :class="{ 'active':nav.name.includes($route.name.split('.')[0]) }">
                    <router-link :to="{name: nav.name}" class="nav-link">
                        <b>{{ nav.title }}</b>
                    </router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="user">
                     <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b> {{ user.pseudo }} </b> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <router-link :to="{name: 'player.show', params: {id: user.id}}" class="dropdown-item font-weight-bold">
                            <i class="fas fa-cog"></i>
                            Profile
                        </router-link>
                        
                        <a href="/admin" class="dropdown-item font-weight-bold" v-if="isAdmin">
                            <i class="fas fa-user-shield"></i>
                            Go to admin
                        </a>
                        
                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item text-danger font-weight-bold" @click="logout()">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </li>

                <li class="nav-item" v-show="!user">
                    <router-link :to="{name: 'login'}" class="btn btn-success">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </router-link>
                
                    <router-link :to="{name: 'register'}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Register
                    </router-link>
                
                </li>
                <li class="nav-item">
                
                </li>
                <li class="nav-item">
                
                </li>
            </ul>

        </div>
    </div>
</template>
<script>
export default {
        data() {
            return {
                loading: false,
                authenticated: auth.check(),
                user: null,
                navs: [
                    {name: 'players', title:'Players',},
                    {name: 'teams', title:'Teams',},
                    {name: 'tournaments', title: 'Register to tournament'},
                    {name: 'rules', title:'Rules',},
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

            logout() {
                this.loading = true
                axios.get('/api/logout')
                .then(response => {
                    this.loading = false
                    this.$router.push( {name: 'home'} )
                })
                .catch(() => {
                    this.loading = false
                })

                auth.logout()

                this.user = null
            }
        },

        mounted() {
            if (this.authenticated) {
                this.user = this.getUser()
            }
        },

        computed: {
            isAdmin() {
                if (this.authenticated) {
                    if (this.user && this.user.admin) {
                        return true
                    }
                    return false
                }
            }
        }
    }
</script>

<style>

</style>
