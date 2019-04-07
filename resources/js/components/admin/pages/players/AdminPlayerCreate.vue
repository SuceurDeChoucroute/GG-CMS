<template>
    <div>
        <admin-content-header page_name="Add player" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToPlayerList()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>
                Return to player list
            </button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create player</h3>
                        </div>
                        <div class="box-body">
                            <form @submit.prevent="createPlayer()" class="form-horizontal">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="player.name" required>
                                    </div>
                                </div>

                                <!-- Birth Date -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Birth Date</label>

                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="birth_date" placeholder="Birth Date" v-model="player.birth_date" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" placeholder="Email" v-model="player.email" required>
                                    </div>
                                </div>

                                <!-- Pseudo -->
                                <div class="form-group">
                                    <label for="pseudo" class="col-sm-2 control-label">Pseudo</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="pseudo" placeholder="Pseudo" v-model="player.pseudo" required>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-8">
                                        <textarea id="description" cols="30" rows="5" max="250" class="form-control" style="resize: none;" v-model="player.description" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="avatar" class="col-sm-2 control-label">Avatar</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="avatar" placeholder="Avatar" v-model="player.avatar" required>
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
export default {
    data() {
        return {
            loading: false,
            player: {
                name: '',
                email: '',
                pseudo: '',
                avatar: '',
                birth_date: '',
                description: '',
                password: 'secret',
            }
        }
    },

    methods: {
        goToPlayerList() {
            this.$router.push({name: 'players'});
        },

        createPlayer() {
            axios.post('/api/players', this.player)
            .then(response => {
                this.loading = false

                this.flashMessage.success({
                    title: "Players added !",
                    message: "The player has been successfully added"
                })

                this.$router.push({ name: 'player.show', params: {id: response.data.id} })
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        }
    }
}
</script>

<style>

</style>
