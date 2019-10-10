<template>
    <div>
        <admin-content-header page_name="User profile" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
                <button @click="goToPlayerList()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Return to player list
                </button>
            <div class="row">
                <div class="col-md-3">
                    <!-- Pseudo & Avatar -->
                    <div class="box box-primary">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <div class="box-body box-profile" v-show="!loading">
                            <img class="profile-user-img img-responsive img-circle" :src="player.avatar" alt="User profile picture">

                            <h3 class="profile-username text-center"> 
                                {{ player.pseudo }}
                                <span v-show="player.admin" class="badge bg-green" title="Admin"><i class="fas fa-user-shield"></i></span>
                            </h3>
                            <p class="text-muted text-center"> {{ player.email }} </p>
                            <p class="text-center">
                                <button class="btn btn-success" @click="toggleAdmin()">
                                    <i class="fas fa-arrow-alt-circle-up"></i>
                                </button>
                            </p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item" v-for="(participation, key) in player.tournamentsParticipation" :key="key">
                                    <b> {{ participation.tournament_name }} </b> 
                                    <a class="pull-right"> {{ participation.place }} </a>
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
                                <h3> Player informations </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <form class="form-horizontal" v-show="!loading">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" v-model="player.name" disabled>
                                        </div>
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" v-model="player.email" disabled>
                                        </div>
                                    </div>

                                    <!-- Birth Date -->
                                    <div class="form-group">
                                        <label for="birth_date" class="col-sm-2 control-label">Birth Date</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="birth_date" v-model="player.birth_date" disabled>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="player.description" disabled></textarea>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <h3> Player teams </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>
                                
                                <!-- Player teams -->
                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Game</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(team, key) in teams" :key="key">
                                            <td> {{ team.name }} </td>
                                            <td> {{ teamGames[key].name }} </td>
                                            <td>
                                                <router-link :to="{ name: 'team.show', params: {id: team.id} }" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <hr>
                                <h3> Player games </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <!-- Player games -->
                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Game</th>
                                            <th>Rank</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(game, key) in games" :key="key">
                                            <td> {{ game.name }} </td>
                                            <td> {{ game.rank }} </td>
                                            <td>
                                                <router-link :to="{ name: 'game.show', params: {id: game.id} }" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="settings">
                                <form @submit.prevent="updatePlayer()" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="player.name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pseudo" class="col-sm-2 control-label">Pseudo</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="pseudo" placeholder="Pseudo" v-model="player.pseudo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="player.description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="avatar" class="col-sm-2 control-label">Avatar</label>

                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="avatar" placeholder="https://..." v-model="player.avatar">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-check" v-show="!loading"></i>
                                                Update
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deletePlayer()">
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
            player: {},
            teams: [],
            teamGames: [],
            games: [],
        }
    },

    methods: {
        // Go back to the previous page
        goToPlayerList() {
            this.$router.push({name: 'players'});
        },

        // Get player info
        getPlayer(id) {
            this.loading = true
            axios.get('/api/players/' + id)
            .then(response => {
                this.player = response.data.player
                this.teams = response.data.teams
                this.teamGames = response.data.teamGames
                this.games = response.data.games
                this.loading = false
            })
        },

        // Update the player
        updatePlayer() {
            this.loading = true;
            
            axios.put('/api/players/' + this.player.id, this.player)
            .then(response => {
                this.player = response.data
                this.loading = false
                this.flashMessage.success({
                    title: "Player updated !",
                    message: "The player has been successfully updated"
                })
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        },

        // Delete player
        deletePlayer() {
            if (confirm("Are you sure you want to delete this player ? It's definitive")) {
                this.loading = true;
            
                axios.delete('/api/players/' + this.player.id)
                .then(response => {
                    this.loading = false
                    this.flashMessage.success({
                        title: "Players deleted !",
                        message: "The player has been successfully deleted"
                    })
                })
                .catch(e => {
                    this.loading = false
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                })
                
                this.goToPlayerList();
            }
        },

        toggleAdmin() {

        }
    },

    mounted() {
        this.getPlayer(this.$route.params.id)
    },
}
</script>

<style>

</style>
