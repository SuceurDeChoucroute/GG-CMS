<template>
    <div>
        <admin-content-header page_name="Post preview" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToPostsList()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to post list
            </button>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Posts
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'post.edit', params: {id: post.id}}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </router-link>
                                <button class="btn btn-info" @click="getPosts()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <div v-show="!loading">
                                <h1> {{ post.title }} </h1>
                                <div v-html="post.content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import AdminContentHeader from './../../layouts/AdminContentHeader'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        AdminContentHeader,
        Loader
    },

    data() {
        return {
            loading: false,
            post: {},
        }
    },

    methods: {
        // Go back to the previous page
        goToPostsList() {
            this.$router.push({name: 'posts'});
        },

        // Get post
        getPost() {
            let id = this.$route.params.id;
            this.loading = true

            axios.get('/api/posts/' + id)
            .then(response => {
                this.post = response.data

                this.loading = false
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        },
    },

    mounted() {
        this.getPost()
    },
}
</script>

<style>

</style>
