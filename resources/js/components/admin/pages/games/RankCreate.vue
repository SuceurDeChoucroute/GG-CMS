<template>
    <div>
        <admin-content-header page_name="Add game" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToGameShow()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to game
            </button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create rank</h3>
                        </div>
                        <div class="box-body">
                            <form @submit.prevent="createRank()" class="form-horizontal">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="rank.name" required>
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image" class="col-sm-2 control-label">Image</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="image" placeholder="https://..." v-model="rank.image">
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
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            rank: {
                name: '',
                image: '',
                game_id: this.$route.params.id,
            },
        }
    },

    methods: {
        goToGameShow() {
            this.$router.push({ name: 'game.show', params: {id: this.rank.game_id} })
        },

        createRank() {
            let id = this.$route.params.id
            this.loading = true

            axios.post('/api/games/' + id + '/ranks', this.rank)
            .then(response => {
                this.loading = false
                this.flashMessage.success({
                    title: "Rank added !",
                    message: "The rank has been successfully added"
                })
                this.$router.push({ name: 'game.show', params: {id: id} })
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
}
</script>

<style>

</style>
