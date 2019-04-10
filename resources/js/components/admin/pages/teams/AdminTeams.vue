<template>
    <div>
        <admin-content-header page_name="Teams" page_description="Manage your teams"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Teams
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'team.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                                <button class="btn btn-info" @click="getTeams()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <table class="table table-dark table-hover table-striped" id="teams" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Players</th>
                                        <th>Game</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(team, key) in teams" :key="key">
                                        <td>{{ team.name }}</td>
                                        <td>{{ team.players }}</td>
                                        <td>{{ team.game }}</td>
                                        <td>
                                            <router-link :to="{ name: 'team.show', params: {id: team.id} }" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
            teams: [
                { id:1, name: "Berzerker", players: 4, game: "ForHonor" },
                { id:2, name: "FritesAuFourSalé", players: 5, game: "CS:GO" },
                { id:3, name: "No pain no choucroute", players: 3, game: "CS:GO" },
                { id:4, name: "Enraged Warriors", players: 2, game: "ForHonor" },
                { id:5, name: "Obvious Kill", players: 5, game: "CS:GO" },
                { id:6, name: "No Beta Test", players: 1, game: "ForHonor" },
            ],
            team: {
                id: 99,
                name: "Test Team",
                players: 10,
                game: "CS:GO",
            }
        }
    },

    methods: {
        addTeam() {
            this.teams.push(this.team)
            this.flashMessage.success({
                title: "Team added !",
                message: "The team has been successfully added"
            })
        },
    },
}
</script>

<style>

</style>
