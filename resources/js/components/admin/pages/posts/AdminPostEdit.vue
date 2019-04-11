<template>
    <div>
        <admin-content-header page_name="Add post" ></admin-content-header>
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
                            <form @submit.prevent="updatePost()" class="form-horizontal">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="title" placeholder="Title" v-model="post.title" required>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-8">
                                        <ckeditor :editor="editor" v-model="post.content"></ckeditor>
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
                                            Create
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

export default {
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
            this.loading = true

            this.post = {
                id: 1,
                title: 'GG-LAN #9',
                content: "<h2>Annonce GG-LAN #9</h2>",
                author: 'Thibaud',
                visibility: 'private',
                created_at: '2019-04-11',
                image: 'https://pbs.twimg.com/profile_images/1006631933944778754/kc_0KO-Q_400x400.jpg',
            }

            this.loading = false
            // axios.post('/api/players', this.player)
            // .then(response => {
            //     this.loading = false

            //     this.flashMessage.success({
            //         title: "Players added !",
            //         message: "The player has been successfully added"
            //     })

            //     this.$router.push({ name: 'player.show', params: {id: response.data.id} })
            // })
            // .catch(e => {
            //     this.loading = false
            //     this.flashMessage.error({
            //         title: "Something went wrong",
            //         message: "Please try again"
            //     })
            // })
        },

        updatePost() {
            this.loading = true

            console.log(this.post)

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
