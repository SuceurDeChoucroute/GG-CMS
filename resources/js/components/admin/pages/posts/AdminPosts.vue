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
                                        <th>Author</th>
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
                                        <td>{{ post.author }}</td>
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
            posts: [],
        }
    },

    methods: {
        getPosts() {
            this.loading = true
            
            this.posts = [
                {id: 1, title: 'TITLE', author: 'NAME', created_at:'1999-01-01', visibility: 'public'},
                {id: 1, title: 'TITLE', author: 'NAME', created_at:'1999-01-01', visibility: 'private'},
                {id: 1, title: 'TITLE', author: 'NAME', created_at:'1999-01-01', visibility: 'public'},
                {id: 1, title: 'TITLE', author: 'NAME', created_at:'1999-01-01', visibility: 'private'},
                {id: 1, title: 'TITLE', author: 'NAME', created_at:'1999-01-01', visibility: 'public'},
            ]

            this.loading = false
        },
    },

    mounted() {
        this.getPosts()
    }
}
</script>

<style>

</style>
