<template>
    <div>
        <admin-content-header page_name="User profile" ></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
                <button @click="goBack()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Return to player list
                </button>
            <div class="row">
                <div class="col-md-3">
                    <!-- Pseudo & Avatar -->
                    <div class="box box-primary">
                        <loader :color="'#337ab7'" v-show="loading"></loader>
                        <div class="box-body box-profile" v-show="!loading">
                            <img class="profile-user-img img-responsive img-circle" src="https://gglan.fr/storage/avatars/pVZJ8PnP8ZkiapOtMiXtkzWrYVlxkGRuY1hQdgfQ.jpeg" alt="User profile picture">

                            <h3 class="profile-username text-center"> {{ player.pseudo }} </h3>
                            <p class="text-muted text-center"> {{ player.email }} </p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item" v-show="!loading">
                                    <b>GG-LAN#8</b> 
                                    <a class="pull-right">3rd</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- About me -->
                    <!-- <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">About Me</h3>
                        </div>
                        <div class="box-body">
                            <strong>Description</strong>

                            <p class="text-muted">
                                {{ player.description }}
                            </p>

                            <hr>
                        </div>
                    </div> -->
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

                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Game</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(team, key) in player.teams" :key="key">
                                            <td> {{ team.name }} </td>
                                            <td> {{ team.game }} </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <hr>
                                <h3> Player games </h3>
                                <loader :color="'#337ab7'" v-show="loading"></loader>

                                <table class="table table-striped table-hover" v-show="!loading">
                                    <thead>
                                        <tr>
                                            <th>Game</th>
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(game, key) in player.games" :key="key">
                                            <td> {{ game.name }} </td>
                                            <td> {{ game.rank }} </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
import AdminContentHeader from './../layouts/AdminContentHeader'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        AdminContentHeader,
        Loader
    },

    data() {
        return {
            loading: false,
            player: {
                id: this.$route.params.id,
                name: "John Doe",
                email: 'john.doe@example.com',
                birth_date: '01/01/1999',
                pseudo: "Amiral Choucroute",
                description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, mollitia!",
                teams: [
                    { name: "ElPaso", game: "CS:GO"},
                    { name: "Berzerker", game: "ForHonor"},
                ],
                games: [
                    { name: "CS:GO", rank: "Eagle II"},
                    { name: "ForHonor", rank: "Berserker"},
                ],
            },


            playerBeforeUpdate: {
                name: "John Doe",
                email: 'john.doe@example.com',
                birth_date: '01/01/1999',
                pseudo: "Amiral Choucroute",
                description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, mollitia!",
            }
        }
    },

    methods: {
        // Go back to the previous page
        goBack() {
            this.$router.go(-1);
        },

        // Update the player
        updatePlayer() {
            this.loading = true;
            if (this.player.name != this.playerBeforeUpdate.name || 
                this.player.pseudo != this.playerBeforeUpdate.pseudo || 
                this.player.description != this.playerBeforeUpdate.description) {

                // Update player info before update
                this.playerBeforeUpdate.name = this.player.name
                this.playerBeforeUpdate.pseudo = this.player.pseudo
                this.playerBeforeUpdate.description = this.player.description
                
                this.flashMessage.success({
                    title: "Player updated !",
                    message: "The player has been successfully updated"
                })
            }
            else {
                this.flashMessage.error({
                    title: "You didn't change any fields !",
                    message: "You have to change a least one field to update the player"
                })
            }

            this.loading = false;
        },
    }
}
</script>

<style>

</style>
