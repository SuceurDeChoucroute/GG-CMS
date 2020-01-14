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
                            <AdminDataTable :data="tournaments" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Payed Players
                            </h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-info" @click="getPayedPlayers()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <AdminDataTable :data="payedPlayers" :columns="payedPlayersColumns" :index="false" :loading="payedPlayersLoading"></AdminDataTable>
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
            payedPlayersLoading: false,
            tournaments: [],
            payedPlayers: [],
            columns: [
                {name: 'name', th: 'Name', render(row, cell, index) {
                    return row.tournament.name
                }},
                {name: 'name', th: 'Game', render(row, cell, index) {
                    return row.game.name
                }},
                {name: 'date', th: 'Date', render(row, cell, index) {
                    return moment(row.tournament.start_date).format("DD/MM/YYYY") + ' | ' + moment(row.tournament.end_date).format("DD/MM/YYYY")
                }},
                {name: 'place', th: 'Places', render(row, cell, index) {
                    return row.tournament.places
                }},
                {name: 'cashprize', th: 'Cashprize', render(row, cell, index)  {
                    return row.tournament.cashprize
                }},
                {name: 'status', th: 'Status', render(row, cell, index) {
                    switch (row.tournament.status) {
                        case 'Open':
                            return '<span class="badge bg-green">' + row.tournament.status + '</span>'
                            break;

                        case 'Closed':
                            return '<span class="badge bg-red">' + row.tournament.status + '</span>'
                            break;

                        case 'Finished':
                            return '<span class="badge bg-orange">' + row.tournament.status + '</span>'
                            break;
                    
                        default:
                            break;
                    }
                }},
            ],
            payedPlayersColumns: [
                { name: 'tournament_name', th: 'Tournament' },
                { name: 'user_pseudo', th: 'Player' }
            ],
            actions: [
                {text: "", icon: "fas fa-eye", color: "primary", action: (row, index) => {
                    this.$router.push({ name: 'tournament.show', params: {id: row.tournament.id} })
                }},
            ],
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
        },

        getPayedPlayers() {
            this.payedPlayersLoading = true
            axios.get('/api/tournaments/payed/players')
            .then(response => {
                this.payedPlayers = response.data
                this.payedPlayersLoading = false
            })
            .catch(e => {
                this.payedPlayersLoading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please refresh the page"
                })
            })
        }
    },
    
    mounted() {
        this.getTournaments()
        this.getPayedPlayers()
    }
}
</script>

<style>

</style>
