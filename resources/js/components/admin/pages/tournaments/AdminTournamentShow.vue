<template>
    <div>
        <admin-content-header page_name="Game profile" ></admin-content-header>
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

                            <h3 class="profile-username text-center"> {{ tournament.name }} </h3>
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
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(player, key) in tournamentPlayers" :key="key">
                                            <td> {{ player.pseudo }} </td>
                                            <td> {{ player.rank }} </td>
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
                                            <loader :color="'#337ab7'" v-show="loading"></loader>
                                            <select name="game" id="game" class="form-control" v-show="!loading" required>
                                                <option disabled selected>-- Please choose the game --</option>
                                                <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Start & End Date -->
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Start & End Date</label>

                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="startDate" v-model="tournament.startDate" required>
                                        </div>
                                        
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="endDate" v-model="tournament.endDate" required>
                                        </div>
                                    </div>

                                    <!-- Place -->
                                    <div class="form-group">
                                        <label for="place" class="col-sm-2 control-label">Place</label>

                                        <div class="col-sm-10">
                                            <input type="number" min="0" step="1" class="form-control" id="place" placeholder="Place" v-model="tournament.place" required>
                                        </div>
                                    </div>

                                    <!-- Cashprize -->
                                    <div class="form-group">
                                        <label for="cashprize" class="col-sm-2 control-label">Cashprize</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="cashprize" placeholder="Cashprize" v-model="tournament.cashprize" required>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="form-group">
                                        <label for="image" class="col-sm-2 control-label">Image</label>

                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="image" placeholder="https://..." v-model="tournament.image" required>
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

                                            <button type="button" class="btn btn-danger" @click="deleteTournament(tournament.id)">
                                                <i class="fas fa-trash-alt"></i>
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
            tournament: {
                id: this.$route.params.id,
                name: 'GG-LAN #8',
                description: "New edition of GG-LAN",
                game: 'ForHonor',
                startDate: '1999-01-01',
                endDate: '1999-01-02',
                place: '10',
                cashprize: '500 €',
                status: 'Open',
                image: 'https://gglan.fr/storage/posts/KwPzfnoC2JiLSvYcG1z3WuGqF4PYVWDq5MGH1xqd.jpeg',
            },
            tournamentBeforeUpdate: {
                id: this.$route.params.id,
                name: 'GG-LAN #8',
                description: "New edition of GG-LAN",
                game: 'ForHonor',
                startDate: '1999-01-01',
                endDate: '1999-01-02',
                place: '10',
                cashprize: '500 €',
                status: 'Open',
                image: 'https://gglan.fr/storage/posts/KwPzfnoC2JiLSvYcG1z3WuGqF4PYVWDq5MGH1xqd.jpeg',
            },
            tournamentPlayers: [
                {id: 1, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !", rank: "Eagle II"},
                {id: 2, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !", rank: "Global Elite"},
                {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !", rank: "Sivler III"},
                {id: 3, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !", rank: "Noob"},
            ],

            games: [
                { id: 1, name: "CS:GO", description: "An amazing FPS shooter", place: 5 },
                { id: 2, name: "ForHonor", description: "Now you are an ultimate warrior", place: 4 },
            ],
        }
    },

    methods: {
        // Go back to the previous page
        goToTournamentsList() {
            this.$router.push({name: 'tournaments'});
        },

        // Update the tournament
        updateTournament() {
            this.loading = true;
            if (this.tournamentBeforeUpdate.name != this.tournament.name ||
                this.tournamentBeforeUpdate.description != this.tournament.description ||
                this.tournamentBeforeUpdate.game != this.tournament.game ||
                this.tournamentBeforeUpdate.startDate != this.tournament.startDate ||
                this.tournamentBeforeUpdate.endDate != this.tournament.endDate ||
                this.tournamentBeforeUpdate.place != this.tournament.place ||
                this.tournamentBeforeUpdate.cashprize != this.tournament.cashprize ||
                this.tournamentBeforeUpdate.status != this.tournament.status ||
                this.tournamentBeforeUpdate.image != this.tournament.image) {

                // Update tournament info before update
                this.tournamentBeforeUpdate.name = this.tournament.name
                this.tournamentBeforeUpdate.description = this.tournament.description
                this.tournamentBeforeUpdate.game = this.tournament.game
                this.tournamentBeforeUpdate.startDate = this.tournament.startDate
                this.tournamentBeforeUpdate.endDate = this.tournament.endDate
                this.tournamentBeforeUpdate.place = this.tournament.place
                this.tournamentBeforeUpdate.cashprize = this.tournament.cashprize
                this.tournamentBeforeUpdate.status = this.tournament.status
                this.tournamentBeforeUpdate.image = this.tournament.image
                
                this.flashMessage.success({
                    title: "Tournament updated !",
                    message: "The tournament has been successfully updated"
                })
            }
            else {
                this.flashMessage.error({
                    title: "You didn't change any fields !",
                    message: "You have to change a least one field to update the tournament"
                })
            }

            this.loading = false;
        },

        // Delete the tournament
        deleteTournament(id) {
            if (confirm("Are you sure you want to delete this tournament ? It's definitive")) {
                this.flashMessage.success({
                    title: "Tournament deleted !",
                    message: "The tournament has been successfully deleted"
                })
                this.goToTournamentsList();
            }

            // this.flashMessage.error({
            //     title: "Something went wrong",
            //     message: "Please try again"
        },
    }
}
</script>

<style>

</style>
