<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 text-center mx-auto">
                <h1>Login</h1>
                <form @submit.prevent="login()">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.email" placeholder="Email" required>
                            <div class="invalid-feedback" v-show="error">
                                Incorrect credentials
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-unlock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" :class=" { 'is-invalid' : error } " v-model="user.password" placeholder="Password" required>
                            <div class="invalid-feedback" v-show="error">
                                Incorrect credentials
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success text-center" :disabled="loading">
                        Login
                        <b-spinner small variant="dark" label="Loading" v-show="loading"></b-spinner>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            error: false,
            loading: false,

            user: {
                email: '',
                password: '',
            }
        };
    },

    methods: {
        login() {
            this.loading = true
            this.error = false

            axios.post('/api/login', this.user)
            .then(response => {
                this.loading = false
                auth.login(response.data.token)
                window.location.href = '/'
            })
            .catch(response => {
                this.loading = false
                this.error = true
            });
        }
    }
}
</script>