<template>
    <div>
        <admin-content-header page_name="Add team" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <button @click="goToTeamList()" class="btn btn-primary">
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
                            <form @submit.prevent="createTeam()" class="form-horizontal">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="team.name" required>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>

                                    <div class="col-sm-8">
                                        <textarea id="description" cols="30" rows="5" max="250" class="form-control" style="resize: none;" v-model="team.description" required></textarea>
                                    </div>
                                </div>

                                <!-- Captain -->
                                <div class="form-group">
                                    <label for="avatar" class="col-sm-2 control-label">Captain</label>

                                    <div class="col-sm-8">
                                        <loader :color="'#337ab7'" v-show="loading"></loader>
                                        <select name="captain" id="captain" class="form-control" v-show="!loading">
                                            <option disabled selected>-- Please choose the captain --</option>
                                            <option :value="player.id" v-for="(player, key) in players" :key="key"> {{ player.pseudo }} </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Avatar -->
                                <div class="form-group">
                                    <label for="avatar" class="col-sm-2 control-label">Avatar</label>

                                    <div class="col-sm-8">
                                        <input type="url" class="form-control" id="avatar" placeholder="https://imgur.com" required>
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
            team: {
                id: 99,
                name: '',
                description: '',
                avatar: '',
                captain: {}
            },
            players: [],
        }
    },

    methods: {
        goToTeamList() {
            this.$router.push({name: 'teams'});
        },

        createTeam() {
            this.$router.push({ name: 'team.show', params: {id: this.team.id} })
            this.flashMessage.success({
                title: "Team added !",
                message: "The team has been successfully added"
            })
        },

        getPlayers() {
            this.loading = true
            
            this.players = [
                {id: 1, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 2, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                {id: 3, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 4, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 5, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
            ]

            this.loading = false
        }
    },

    mounted() {
        this.getPlayers()
    }
}
</script>

<style>

</style>
