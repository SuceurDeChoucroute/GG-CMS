<template>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <router-link :to="{name: 'home'}" class="navbar-brand">
            Home
        </router-link>
        <div class="collapse navbar-collapse mr-auto" id="navbarDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link :to="{name: 'teams'}" class="nav-link">Teams</router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name: 'rules'}" class="nav-link">Rules</router-link>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item" v-if="user">
                     <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b> {{ user.pseudo }} </b> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="/admin" class="dropdown-item" v-if="isAdmin">Go to admin</a>
                        <a href="#" class="dropdown-item" @click="logout()">Logout</a>
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
                user: null
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
