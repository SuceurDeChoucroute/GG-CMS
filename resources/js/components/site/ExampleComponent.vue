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

                    <router-link :to="{name: 'login'}" v-else>
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </router-link>

                    <!-- <a href="/admin" class="btn btn-primary" v-if="user.admin"> Go to admin </a> -->
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
        }
    }
</script>
