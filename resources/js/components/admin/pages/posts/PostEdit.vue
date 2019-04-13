<template>
    <div>
        <admin-content-header page_name="Edit post" ></admin-content-header>
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
                            <h3 class="box-title">Create post</h3>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <form @submit.prevent="updatePost()" class="form-horizontal" v-show="!loading">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="title" placeholder="Title" v-model="post.title" required>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">Content</label>
                                    <div class="col-sm-8">
                                        <ckeditor :editor="editor" v-model="post.content"></ckeditor>
                                    </div>
                                </div>

                                <!-- Visibility -->
                                <div class="form-group">
                                    <label for="visibility" class="col-sm-2 control-label">Visibility</label>

                                    <div class="col-sm-8">
                                        <select name="visibility" id="visibility" v-model="post.visibility" class="form-control">
                                            <option value="public">public</option>
                                            <option value="private">private</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Cover -->
                                <div class="form-group">
                                    <label for="image" class="col-sm-2 control-label">Cover</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="image" placeholder="https://..." v-model="post.image">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                            <i class="fas fa-check" v-show="!loading"></i>
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            editor: ClassicEditor,
            post: {},
        }
    },

    methods: {
        goToPostsList() {
            this.$router.push({name: 'posts'});
        },

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

        updatePost() {
            let id = this.$route.params.id;
            this.loading = true

            axios.put('/api/posts/' + id, this.post)
            .then(response => {
                this.flashMessage.success({
                    title: "Post updated !",
                    message: "The post has been successfully updated"
                })

                this.loading = false
                this.$router.push({ name: 'posts' })
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })

            this.loading = false
        }
    },

    mounted() {
        this.getPost()
    }
}
</script>

<style>

</style>
