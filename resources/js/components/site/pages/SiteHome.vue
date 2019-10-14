<template>
    <div>
        <div class="row" v-show="loadingPage">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <site-partners></site-partners>

        <div class="row" v-show="!loadingPage">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4" v-for="(post, key) in posts" :key="key">
                        <div class="card card-small">
                            <router-link :to="{name: 'post.show', params: {id: post.id}}">
                                <img class="card-img-top" :src="post.image" alt="Card image cap">
                            </router-link>
                            <div class="card-body">
                                <h5 class="card-title"> {{ post.title }} </h5>
                                <span class="text-muted"> {{ post.created_at }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loadingPage: false,
                loading: false,
                posts: [],
            }
        },

        methods: {
            getPosts() {
                this.loadingPage = true
                axios.get('/api/posts/public')
                .then(response => {
                    this.posts = response.data
                    this.loadingPage = false
                })
                .catch(() => {
                    this.$noty.error("Something went wrong... Try again")
                    this.loadingPage = false
                })
            },
        },

        mounted() {
            this.getPosts()
        }
    }
</script>
