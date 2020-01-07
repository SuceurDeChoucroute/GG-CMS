<template>
    <div>
        <admin-content-header page_name="Tournament profile" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
                <button @click="goToTournamentsList()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Return to tournament list
                </button>
            <div class="row">
                <div class="col-md-3">
                    <!-- Pseudo & Avatar -->
                    <div class="box box-primary">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <div class="box-body box-profile" v-show="!loading">
                            <img class="profile-user-img img-responsive img-circle" :src="tournament.image" alt="User profile picture">

                            <h3 class="profile-username text-center"> 
                                {{ tournament.name }}
                                <span v-if="tournament.status == 'Open'" class="badge bg-green">{{ tournament.status }}</span>
                                <span v-else-if="tournament.status == 'Closed'" class="badge bg-red">{{ tournament.status }}</span>
                                <span v-else class="badge bg-orange">{{ tournament.status }}</span>
                            </h3>
                            <p class="text-muted text-center">{{ tournament.description }} </p>

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
                                <h3> Tournament informations </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <form class="form-horizontal" v-show="!loading">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" v-model="tournament.name" disabled>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="tournament.description" disabled></textarea>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <h3> Registered players </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Pseudo</th>
                                            <!-- <th>Rank</th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="players.length == 0" class="text-center">
                                            <td colspan="2"> No players subscribe to this tournament </td>
                                        </tr>

                                        <tr v-for="(player, key) in players" :key="key" v-else>
                                            <td> {{ player.pseudo }} </td>
                                            <!-- <td> {{ player.rank }} </td> -->
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
                                <form @submit.prevent="updateTournament()" class="form-horizontal">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="tournament.name" required>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description</label>

                                        <div class="col-sm-10">
                                            <textarea id="description" cols="30" rows="5" class="form-control" style="resize: none;" v-model="tournament.description" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Game -->
                                    <div class="form-group">
                                        <label for="game" class="col-sm-2 control-label">Game</label>

                                        <div class="col-sm-10">
                                            <select name="game_id" id="game_id" class="form-control" v-model="tournament.game_id" required>
                                                <option disabled>-- Please choose the game --</option>
                                                <option disabled selected :value="tournamentGame.id"> {{ tournamentGame.name }} </option>
                                                <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Start & End Date -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Start & End Date</label>

                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="startDate" v-model="tournament.start_date" required>
                                        </div>
                                        
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="endDate" v-model="tournament.end_date" required>
                                        </div>
                                    </div>

                                    <!-- Places -->
                                    <div class="form-group">
                                        <label for="places" class="col-sm-2 control-label">Places</label>

                                        <div class="col-sm-10">
                                            <input type="number" min="0" step="1" class="form-control" id="places" placeholder="Places" v-model="tournament.places" required>
                                        </div>
                                    </div>

                                    <!-- Cashprize -->
                                    <div class="form-group">
                                        <label for="cashprize" class="col-sm-2 control-label">Cashprize</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="cashprize" placeholder="Cashprize" v-model="tournament.cashprize" required>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="game" class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">
                                            <select name="game_id" id="game_id" class="form-control" v-model="tournament.status" required>
                                                <option disabled selected :value="tournament.status"> {{ tournament.status }} </option>
                                                <option value="Open"> Open </option>
                                                <option value="Closed"> Closed </option>
                                                <option value="Finished"> Finished </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="form-group">
                                        <label for="image" class="col-sm-2 control-label">Image</label>

                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="image" placeholder="https://..." v-model="tournament.image" required>
                                        </div>
                                    </div>

                                    <!-- Stripe Product Key -->
                                    <div class="form-group">
                                        <label for="stripe_key" class="col-sm-2 control-label">Stripe Product Key</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="stripe_key" placeholder="ex: sku_XXXXXXXXXXXXXX" v-model="tournament.stripe_key">
                                        </div>
                                    </div>
                                    
                                    <!-- Update & Delete -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-check" v-show="!loading"></i>
                                                Update
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deleteTournament()">
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
            tournament: {},
            tournamentGame: {},
            players: [],
            games: [],
        }
    },

    methods: {
        // Go back to the previous page
        goToTournamentsList() {
            this.$router.push({name: 'tournaments'});
        },

        // Get tournament
        getTournament() {
            let id = this.$route.params.id
            this.loading = true

            axios.get('/api/tournaments/' + id)
            .then(response => {
                this.tournament = response.data.tournament
                this.tournamentGame = response.data.tournamentGame
                this.getPlayers()

                this.loading = false
            })
        },

        // Get games
        getGames() {
            axios.get('/api/games')
            .then(response => {
                this.games = response.data
            })
        },

        getPlayers() {
            axios.get('/api/tournaments/' + this.tournament.id + '/players')
            .then(response => {
                this.players = response.data
            })
        },

        // Update tournament
        updateTournament() {
            let id = this.$route.params.id
            this.loading = true;

            axios.put('/api/tournaments/' + id, this.tournament)
            .then(response => {
                this.tournament = response.data.tournament
                this.tournamentGame = response.data.tournamentGame

                this.loading = false
                this.flashMessage.success({
                    title: "Tournament updated !",
                    message: "The tournament has been successfully updated"
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

        // Delete the tournament
        deleteTournament() {
            let id = this.$route.params.id

            if (confirm("Are you sure you want to delete this tournament ? It's definitive")) {
                axios.delete('/api/tournaments/' + id)
                .then(response => {
                    this.flashMessage.success({
                        title: "Tournament deleted !",
                        message: "The tournament has been successfully deleted"
                    })
                    this.goToTournamentsList();
                })
                .catch(e => {
                    this.loading = false
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                })
            }
        },
    },

    mounted() {
        this.getTournament()
        this.getGames()
    }
}
</script>

<style>

</style>
