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
                                <router-link :to="{ name: 'tournament.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                            </h3>
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
                                        <td>{{ tournament.name }}</td>
                                        <td>{{ tournament.game }}</td>
                                        <td>{{ tournament.startDate }} | {{ tournament.endDate }}</td>
                                        <td>{{ tournament.place }}</td>
                                        <td>{{ tournament.cashprize }}</td>
                                        <td v-if="tournament.status == 'Open'"><span class="label label-success">{{ tournament.status }}</span></td>
                                        <td v-else-if="tournament.status == 'Closed'"><span class="label label-danger">{{ tournament.status }}</span></td>
                                        <td v-else><span class="label label-warning">{{ tournament.status }}</span></td>
                                        <td>
                                            <router-link :to="{ name: 'tournament.show', params: {id: tournament.id} }" class="btn btn-primary">
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
            tournaments: [
                { id: 1,name: 'GG-LAN #8', description: "New edition of GG-LAN", game: 'ForHonor', startDate: '01/01/1999', endDate: '02/01/1999', place: '10', cashprize: '500 €', status: 'Open' },
                { id: 2,name: 'GG-LAN #7', description: "New edition of GG-LAN", game: 'CS:GO', startDate: '01/01/1999', endDate: '02/01/1999', place: '16', cashprize: '450 €', status: 'Closed' },
                { id: 3,name: 'GG-LAN #6', description: "New edition of GG-LAN", game: 'CS:GO', startDate: '01/01/1999', endDate: '02/01/1999', place: '16', cashprize: '450 €', status: 'Finished' },
                { id: 4,name: 'GG-LAN #5', description: "New edition of GG-LAN", game: 'CS:GO', startDate: '01/01/1999', endDate: '02/01/1999', place: '16', cashprize: '450 €', status: 'Finished' },
            ],
        }
    },

    methods: {
        
    },
}
</script>

<style>

</style>
