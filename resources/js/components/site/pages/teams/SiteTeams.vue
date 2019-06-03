<template>
    <div class="row">
        <div class="col-lg-12 text-center" v-show="loading">
            <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mb-4" v-for="(team, key) in teams" :key="key" v-show="!loading">
            <div class="card">
                <router-link :to="{name: 'team.show', params: {id: team.team.id}}">
                    <img class="card-img-top" src="https://gglan.fr/storage/avatars/pVZJ8PnP8ZkiapOtMiXtkzWrYVlxkGRuY1hQdgfQ.jpeg" alt="Team avatar">
                </router-link>
                <div class="card-body">
                    <h4 class="card-title"> 
                        {{ team.team.name }}
                        <span class="badge badge-pill badge-warning" v-if="teamPlaces(team) != 'Full'"> {{ teamPlaces(team) }} </span>
                        <span class="badge badge-pill badge-success" v-else> {{ teamPlaces(team) }} </span>
                    </h4>
                    <p class="card-text">Game: <b>{{ team.game.name }}</b></p>
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
            teams: [],
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
            .then(() => {

                this.loading = false
            })
        },

        teamPlaces(team) {
            if (team.players == team.game.places) {
                return 'Full'
            }

            return team.players + ' / ' + team.game.places
        }
    },

    mounted() {
        this.getTeams()
    }
}
</script>

<style>

</style>
