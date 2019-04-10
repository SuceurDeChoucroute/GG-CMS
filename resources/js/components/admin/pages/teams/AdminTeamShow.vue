<template>
    <div>
        <admin-content-header page_name="Team profile" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
                <button @click="goToTeamsList()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Return to team list
                </button>
            <div class="row">
                <div class="col-md-3">
                    <!-- Pseudo & Avatar -->
                    <div class="box box-primary">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <div class="box-body box-profile" v-show="!loading">
                            <img class="profile-user-img img-responsive img-circle" :src="team.avatar" alt="User profile picture">

                            <h3 class="profile-username text-center"> {{ team.name }} </h3>
                            <p class="text-muted text-center"> Game: {{ game.name }} </p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item" v-for="(participation, key) in participations" :key="key">
                                    <b> {{ participation.name }} </b> 
                                    <a class="pull-right"> 
                                        <span v-if="participation.pivot.place == 3">
                                            <i class="fas fa-trophy text-danger" >3rd</i>
                                        </span>
                                        <span v-else-if="participation.pivot.place == 2">
                                            <i class="fas fa-trophy text-warning" >2nd</i>
                                        </span>
                                        <span v-else-if="participation.pivot.place == 1">
                                            <i class="fas fa-trophy text-success" >1st</i>
                                        </span>
                                        <span v-else>
                                            <i class="fas fa-trophy" > {{ participation.pivot.place }}th</i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#profile" data-toggle="tab">Profile</a>
                            </li>
                            <li v-show="!loading">
                                <a href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="profile">
                                <h3> Team informations </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <form class="form-horizontal" v-show="!loading">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" v-model="team.name" disabled>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="team.description" disabled></textarea>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <h3> Team players </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Pseudo</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, key) in players" :key="key">
                                            <td> {{ player.pseudo }} </td>
                                            <td> {{ player.description }} </td>
                                            <td class="text-center">
                                                <router-link :to="{ name: 'player.show', params: {id: player.id} }" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="settings">
                                <form @submit.prevent="updateTeam()" class="form-horizontal">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="team.name" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="team.description" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Game -->
                                    <div class="form-group">
                                        <label for="game_id" class="col-sm-2 control-label">Game</label>

                                        <div class="col-sm-10">
                                            <loader :color="'#337ab7'" v-show="loading"></loader>
                                            <select name="game_id" id="game_id" class="form-control" v-show="!loading"  v-model="team.game_id" required>
                                                <option disabled selected>-- Please choose the game --</option>
                                                <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Avatar -->
                                    <div class="form-group">
                                        <label for="avatar" class="col-sm-2 control-label">Avatar</label>

                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="avatar" placeholder="https://..." v-model="team.avatar">
                                        </div>
                                    </div>

                                    <!-- Update & Delete button -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-check" v-show="!loading"></i>
                                                Update
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deleteTeam()">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-trash-alt" v-show="!loading"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
            team: {},
            players: [],
            game: {},
            games: [],
            participations: [],
        }
    },

    methods: {
        // Go back to the previous page
        goToTeamsList() {
            this.$router.push({name: 'teams'});
        },

        // Get team
        getTeam() {
            let id = this.$route.params.id
            this.loading = true

            axios.get('/api/teams/' + id)
            .then(response => {
                this.team = response.data.team
                this.players = response.data.players
                this.game = response.data.game
                this.participations = response.data.participations
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

        getGames() {
            this.loading = true

            axios.get('/api/games')
            .then(response => {
                this.loading = false
                this.games = response.data
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        },

        // Update team
        updateTeam() {
            let id = this.$route.params.id
            this.loading = true;

            axios.put('/api/teams/' + id, this.team)
            .then(response => {
                this.getTeam()
                this.flashMessage.success({
                    title: "Team updated !",
                    message: "The team has been successfully updated"
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
        },

        // Delete team
        deleteTeam() {
            if (confirm("Are you sure you want to delete this team ? It's definitive")) {
                let id = this.$route.params.id
                axios.delete('/api/teams/' + id)
                .then(response => {
                    this.loading = false
                    this.flashMessage.success({
                        title: "Team deleted !",
                        message: "The team has been successfully deleted"
                    })
                    this.loading = true
                    this.goToTeamsList();
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
        this.getTeam()
        this.getGames()
    }
}
</script>

<style>

</style>
