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
                            <AdminDataTable :data="teams" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
                            <!-- <table class="table table-dark table-hover table-striped" id="teams" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Players</th>
                                        <th>Game</th>
                                        <th>Captain</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!teams.length">
                                        <td colspan="5" class="text-center"> No teams registered ... </td>
                                    </tr>
                                    <tr v-else v-for="(team, key) in teams" :key="key">
                                        <td>{{ team.team.name }}</td>
                                        <td v-if="team.players == team.game.places">
                                            <span class="badge bg-green"> Full </span>
                                        </td>
                                        <td v-else>{{ team.players }} / {{ team.game.places }} </td>
                                        <td>
                                            <router-link :to="{ name: 'game.show', params: {id: team.game.id} }">
                                                {{ team.game.name }}
                                            </router-link>
                                        </td>
                                        <td v-if="team.captain"> 
                                            <router-link :to="{ name: 'player.show', params: {id: team.captain.id} }">
                                                {{ team.captain.pseudo }}
                                            </router-link>
                                        </td>
                                        <td v-else></td>
                                        <td>
                                            <router-link :to="{ name: 'team.show', params: {id: team.team.id} }" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> -->
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
            teams: [],
            columns: [
                {name: 'name', th: 'Name', render(row, cell, index) {
                    return row.team.name
                }},
                {name: 'players', th: 'Players', render(row, cell, index) {
                    if (row.players == row.game.places) {
                        return '<span class="badge bg-green">' + row.players + ' / ' + row.game.places + '</span>'
                    }
                    else {
                        return '<span class="badge bg-red">' + row.players + ' / ' + row.game.places + '</span>'
                    }
                }},
                {name: 'game', th: 'Game', render(row, cell, index) {
                    return row.game.name
                }},
                {name: 'captain', th: 'Captain', render(row, cell, index) {
                    return row.captain.pseudo
                }},
            ],
            actions: [
                {text: "", icon: "fas fa-eye", color: "primary btn-pill mr-2", action: (row, index) => {
                    this.$router.push({ name: 'team.show', params: {id: row.team.id} })
                }},
            ],
        }
    },

    methods: {
        getTeams() {
            this.loading = true
            
            axios.get('/api/teams')
            .then(response => {
                this.teams = response.data
                this.loading = false
            })
        },
    },

    mounted() {
        this.getTeams()
    }
}
</script>

<style>

</style>
