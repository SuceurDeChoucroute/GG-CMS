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
                            <AdminDataTable :data="posts" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'
import moment from 'moment'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            posts: [],
            columns: [
                {name: 'title', th: 'Title'},
                {name: 'created_at', th: 'Created At', render(row, cell, index) {
                    return moment(row.created_at).format("DD/MM/YYYY")
                }},
                {name: 'updated_at', th: 'Updated At', render(row, cell, index) {
                    return moment(row.updated_at).format("DD/MM/YYYY")
                }},
                {name: 'visibility', th: 'Visibility', render(row, cell, index) {
                    if (row.visibility == "public") {
                        return '<span class="badge bg-green">' + row.visibility + '</span>'
                    } 
                    else {
                        return '<span class="badge bg-red">' + row.visibility + '</span>'
                    }
                }},
            ],
            actions: [
                {text: "", icon: "fas fa-eye", color: "primary", action: (row, index) => {
                    this.$router.push({ name: 'post.show', params: {id: row.id} })
                }},
                {text: "", icon: "fas fa-edit", color: "success", action: (row, index) => {
                    this.$router.push({ name: 'post.edit', params: {id: row.id} })
                }},
                {text: "", icon: "fas fa-trash", color: "danger", action: (row, index) => {
                    this.deletePost(index)
                }},
            ],
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
