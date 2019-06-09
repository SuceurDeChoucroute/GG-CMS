<template>
    <div>
        <div class="row" v-show="loading">
            <div class="col-lg-12 text-center">
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>
        
        <div class="row" v-show="!loading">
            <div class="col-lg-12" v-for="(tournament, key) in tournaments" :key="key">
                <div class="jumbotron">
                    <h1 class="display-4">
                        {{ tournament.tournament.name }}
                        <span class="badge badge-success" v-if="tournament.registered.length == tournament.tournament.places">
                            {{ tournament|countRegisterTournament }}
                        </span>
                        <span class="badge badge-danger" v-else>
                            {{ tournament|countRegisterTournament }}
                        </span>
                    </h1>
                    
                    <!-- Cashprize -->
                    <h2>
                        Cashprize:
                        <span class="badge badge-danger"> {{ tournament.tournament.cashprize }} </span>
                    </h2>

                    <!-- Description -->
                    <p class="lead"> {{ tournament.tournament.description }} </p>

                    <hr class="my-4">

                    <!-- Date -->
                    <p>
                        Date:
                    <b> {{ tournament.tournament.start_date }} | {{ tournament.tournament.end_date }} </b>
                    </p>

                    <!-- Game -->
                    <p>
                        Game:
                        <b> {{ tournament.game.name }} </b>
                    </p>

                    <!-- Registered -->
                    <p>
                        Registered 
                        <span v-if="tournament.game.places == 1"> players</span> 
                        <span v-else> teams</span> :

                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item" v-for="(registered, key) in tournament.registered" :key="key">
                                <router-link :to="{name: 'team.show', params: {id: registered.id}}" v-if="tournament.registeredType == 'team'"> {{ registered.name }} </router-link>
                                <router-link :to="{name: 'player.show', params: {id: registered.id}}" v-else> {{ registered.pseudo }} </router-link>

                                <span v-if="tournament.registered.length != key + 1"> | </span>
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            tournaments: [],
        }
    },

    methods: {
        getTournaments() {
            this.loading = true
            axios.get('/api/tournaments/open')
            .then(response => {
                this.tournaments = response.data
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
                this.loadingPage = false
            })
        }
    },

    filters: {
        countRegisterTournament(tournament) {
            return tournament.registered.length + ' / ' + tournament.tournament.places
        },
    },

    mounted() {
        this.getTournaments()
    }
}
</script>

<style>

</style>
