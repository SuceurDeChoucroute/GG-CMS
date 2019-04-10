<template>
    <div>
        <admin-content-header page_name="Tournaments" page_description="Manage your tournaments"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Tournaments
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'tournament.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                                <button class="btn btn-info" @click="getTournaments()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <table class="table table-dark table-hover table-striped" id="tournaments" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Game</th>
                                        <th>Date</th>
                                        <th>Place</th>
                                        <th>Cashprize</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tournament, key) in tournaments" :key="key">
                                        <td>{{ tournament.tournament.name }}</td>
                                        <td>{{ tournament.game.name }}</td>
                                        <td>{{ tournament.tournament.start_date }} | {{ tournament.tournament.end_date }}</td>
                                        <td>{{ tournament.tournament.places }}</td>
                                        <td>{{ tournament.tournament.cashprize }}</td>
                                        <td v-if="tournament.tournament.status == 'Open'"><span class="label label-success">{{ tournament.tournament.status }}</span></td>
                                        <td v-else-if="tournament.tournament.status == 'Closed'"><span class="label label-danger">{{ tournament.tournament.status }}</span></td>
                                        <td v-else><span class="label label-warning">{{ tournament.tournament.status }}</span></td>
                                        <td>
                                            <router-link :to="{ name: 'tournament.show', params: {id: tournament.tournament.id} }" class="btn btn-primary">
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
            tournaments: [],
        }
    },

    methods: {
        getTournaments() {
            this.loading = true
            axios.get('/api/tournaments')
            .then(response => {
                this.tournaments = response.data
                this.loading = false
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please refresh the page"
                })
            })
        }
    },
    
    mounted() {
        this.getTournaments()
    }
}
</script>

<style>

</style>
