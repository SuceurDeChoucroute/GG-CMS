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
                            <img class="profile-user-img img-responsive img-circle" src="https://gglan.fr/storage/avatars/pVZJ8PnP8ZkiapOtMiXtkzWrYVlxkGRuY1hQdgfQ.jpeg" alt="User profile picture">

                            <h3 class="profile-username text-center"> {{ team.name }} </h3>
                            <p class="text-muted text-center"> Captain: {{ team.captain.pseudo }} </p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item" v-for="(participation, key) in team.tournamentsParticipation" :key="key">
                                    <b> {{ participation.tournament_name }} </b> 
                                    <a class="pull-right"> 
                                        {{ participation.place }} 
                                        <i class="fas fa-trophy text-danger" v-if="participation.place == '3rd'"></i>
                                        <i class="fas fa-trophy text-warning" v-if="participation.place == '2nd'"></i>
                                        <i class="fas fa-trophy text-success" v-if="participation.place == '1st'"></i>
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
                                        <tr v-for="(player, key) in team.players" :key="key">
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
                                    <!-- <div class="form-group">
                                        <label for="avatar" class="col-sm-2 control-label">Avatar</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="avatar" placeholder="Name">
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync fa-spin" v-show="loading"></i>
                                                <i class="fas fa-check" v-show="!loading"></i>
                                                Update
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deleteTeam(team.id)">
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
            team: {
                id: this.$route.params.id,
                name: "Choucroute Powa",
                description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, mollitia!",
                captain: {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                players: [
                    {id: 1, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 2, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                    {id: 3, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 4, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                ],
                tournamentsParticipation: [
                    { tournament_name: "GG-LAN #8", place: "1st" },
                    { tournament_name: "GG-LAN #7", place: "2nd" },
                    { tournament_name: "GG-LAN #6", place: "3rd" },
                    { tournament_name: "GG-LAN #5", place: "5th" },
                ]
            },
            teamBeforeUpdate: {
                id: this.$route.params.id,
                name: "Choucroute Powa",
                description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, mollitia!",
                captain: {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                players: [
                    {id: 1, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 2, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 6, pseudo: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                    {id: 3, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                    {id: 4, pseudo: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                ],
                tournamentsParticipation: [
                    { tournament_name: "GG-LAN #8", place: "1st" },
                    { tournament_name: "GG-LAN #7", place: "2nd" },
                    { tournament_name: "GG-LAN #6", place: "3rd" },
                    { tournament_name: "GG-LAN #5", place: "5th" },
                ]
            },
        }
    },

    methods: {
        // Go back to the previous page
        goToTeamsList() {
            this.$router.push({name: 'teams'});
        },

        // Update the team
        updateTeam() {
            this.loading = true;
            if (this.team.name != this.teamBeforeUpdate.name || 
                this.team.description != this.teamBeforeUpdate.description) {

                // Update player info before update
                this.teamBeforeUpdate.name = this.team.name
                this.teamBeforeUpdate.description = this.team.description
                
                this.flashMessage.success({
                    title: "Team updated !",
                    message: "The team has been successfully updated"
                })
            }
            else {
                this.flashMessage.error({
                    title: "You didn't change any fields !",
                    message: "You have to change a least one field to update the team"
                })
            }

            this.loading = false;
        },

        // Delete the team
        deleteTeam(id) {
            if (confirm("Are you sure you want to delete this team ? It's definitive")) {
                this.flashMessage.success({
                    title: "Team deleted !",
                    message: "The team has been successfully deleted"
                })
                this.goToTeamsList();
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
