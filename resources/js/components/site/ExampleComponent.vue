<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Example Component</div>

                <div class="card-body">
                    I'm an example component.

                    <span v-if="user">
                        Hello, {{ user.name }}
                        
                        <button class="btn btn-danger" @click="logout()"> Logout </button>
                    </span>

                    <router-link :to="{name: 'login'}" v-else>
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
                axios.get('/api/logout')
                .then(response => {
                    this.$router.push( {name: 'home'} )
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
