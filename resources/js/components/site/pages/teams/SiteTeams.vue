<template>
    <div>
        <div class="row" v-show="loading">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <div class="row" v-show="!loading">
            <div class="col-lg-4 mb-4">
                <form>
                    <div class="form-inline">
                        <input type="text" class="form-control col-sm-12 mb-2" placeholder="Rechercher une équipe" autofocus v-model="search">

                        <!-- <label for="showTeams">Show </label>
                        <select name="showTeams" id="showTeams" class="form-control" v-model="countShowTeams">
                            <option :value="number" v-for="(number, key) in howMuchTeamsCanShow" :key="key"> {{ number }} </option>
                        </select>
                        <label for="showTeams"> Teams</label> -->
                    </div>
                    <label v-show="search"> {{ filteredTeams.length }} équipe(s) filtrée(s)</label>
                </form>
            </div>
        </div>

        <div class="row" v-show="!loading">
            <div class="col-lg-2 col-md-3 col-sm-3 col-4 mb-4" v-for="(team, key) in filteredTeams" :key="key" v-show="(key + 1) <= countShowTeams">
                <div class="card">
                    <router-link :to="{name: 'team.show', params: {id: team.team.id}}">
                        <img class="card-img-top" :src="team.team.avatar" alt="Team avatar">
                    </router-link>
                    <div class="card-body">
                        <h4 class="card-title"> 
                            {{ team.team.name }}
                            <span class="badge badge-pill badge-warning" v-if="teamPlaces(team) != 'Full'"> {{ teamPlaces(team) }} </span>
                            <span class="badge badge-pill badge-success" v-else> {{ teamPlaces(team) }} </span>
                        </h4>
                        <p class="card-text">Jeu: <b>{{ team.game.name }}</b></p>
                    </div>
                </div>
            </div> 
        </div>
        
        <div class="row" v-show="!loading && isMoreShowable">
            <div class="col-lg-6 mb-4 mx-auto text-center">
                <button class="btn btn-lg btn-primary" @click="showMore()">
                    Afficher plus ...
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            countShowTeams: 12,
            search: "",
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
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
                this.loadingPage = false
            })
        },

        teamPlaces(team) {
            if (team.players == team.game.places) {
                return 'Full'
            }

            return team.players + ' / ' + team.game.places
        },

        showMore() {
            this.countShowTeams += 8
        },
    },

    mounted() {
        this.getTeams()
    },

    computed: {
        isMoreShowable() {
            if (this.countShowTeams < this.filteredTeams.length) {
                return true
            }
            return false
        },

        howMuchTeamsCanShow() {
            let count = this.teams.length
            let numbers = []

            for (let index = 8; index < count; index += 8) {
                numbers.push(index)
            }
            numbers.push(count)

            return numbers;
        },

        filteredTeams() {
            if (this.teams && this.search != "") {
               return this.teams.filter((team) => {
                    return team.team.name.toLowerCase().trim().replace(/\s+/g, '').match(this.search.trim().replace(/\s+/g, ''))
                    || team.team.game.name.toLowerCase().trim().match(this.search.trim())
                })
            }
            return this.teams
        }
    }
}
</script>

<style>

</style>
