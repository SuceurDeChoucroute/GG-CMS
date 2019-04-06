<template>
    <div>
        <!-- <admin-content-header page_name="Add player" ></admin-content-header> -->
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToGameList()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to game list
            </button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create game</h3>
                        </div>
                        <div class="box-body">
                            <form @submit.prevent="createGame()" class="form-horizontal">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="game.name" required>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-8">
                                        <textarea id="description" cols="30" rows="5" max="250" class="form-control" style="resize: none;" v-model="game.description" required></textarea>
                                    </div>
                                </div>

                                <!-- Image -->
                                    <div class="form-group">
                                        <label for="image" class="col-sm-2 control-label">Image</label>

                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="image" placeholder="https://..." v-model="game.image" required>
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
            game: {
                id: 99,
                name: '',
                description: '',
                image: '',
            },
        }
    },

    methods: {
        goToGamesList() {
            this.$router.push({name: 'games'});
        },

        createGame() {
            this.loading = true
            this.loading = false
            this.$router.push({ name: 'game.show', params: {id: this.game.id} })
            this.flashMessage.success({
                title: "Game added !",
                message: "The game has been successfully added"
            })
        },
    },
}
</script>

<style>

</style>
