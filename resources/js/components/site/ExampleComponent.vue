<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">
                    I'm an example component.

                    <span v-if="user">
                        Hello, {{ user.name }}
                        
                        <button class="btn btn-danger" @click="logout()">
                            Logout 
                            <b-spinner small variant="dark" label="Loading" v-show="loading"></b-spinner>
                        </button>
                    </span>

                    <span v-else>
                        <router-link :to="{name: 'login'}" >
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </router-link>

                        <router-link :to="{name: 'register'}" >
                            <i class="fas fa-sign-in-alt"></i>
                            Register
                        </router-link>
                    </span>

                    <a href="/admin" class="btn btn-primary" v-if="isAdmin"> Go to admin </a>
                </div>
            </div>
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
                    console.log(this.user.admin)
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
