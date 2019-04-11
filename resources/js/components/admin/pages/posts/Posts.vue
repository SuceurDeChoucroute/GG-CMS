<template>
    <div>
        <admin-content-header page_name="Posts" page_description="Manage your posts"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Posts
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'post.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Create
                                </router-link>
                                <button class="btn btn-info" @click="getPosts()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <table class="table table-dark table-hover table-striped" id="posts" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Visibility</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!posts.length">
                                        <td colspan="5" class="text-center"> No posts registered ... </td>
                                    </tr>
                                    <tr v-else v-for="(post, key) in posts" :key="key">
                                        <td>{{ post.title }}</td>
                                        <td>{{ post.created_at }}</td>
                                        <td>
                                            <span v-if="post.visibility == 'public'" class="badge bg-green">{{ post.visibility }}</span>
                                            <span v-else class="badge bg-red">{{ post.visibility }}</span>
                                        </td>
                                        <td>
                                            <router-link :to="{ name: 'post.show', params: {id: post.id} }" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>

                                            <router-link :to="{ name: 'post.edit', params: {id: post.id} }" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </router-link>

                                            <button class="btn btn-danger" @click="deletePost(key)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            posts: [],
        }
    },

    methods: {
        getPosts() {
            this.loading = true

            axios.get('/api/posts')
            .then(response => {
                this.posts = response.data
                this.loading = false
            })
            .catch(e => {
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
                this.loading = false
            })
        },
        deletePost(key) {
            let id = this.posts[key].id
            if (confirm("Are you sure you want to delete this post ? It's definitive")) {
                this.loading = true
    
                axios.delete('/api/posts/' + id)
                .then(response => {
                    this.getPosts()
                    this.flashMessage.success({
                        title: "Post deleted !",
                        message: "The post has been successfully deleted"
                    })
                    this.loading = false
                })
                .catch(e => {
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                    this.loading = false
                })
            }
        },
    },


    mounted() {
        this.getPosts()
    }
}
</script>

<style>

</style>
