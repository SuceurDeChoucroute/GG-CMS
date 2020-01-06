<template>
    <div>
        <div class="row" v-show="loadingPage">
            <div class="col-lg-12 text-center">
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>
        
        <div class="row" v-show="!loadingPage">
            <div class="col-lg-12" v-for="(tournament, key) in tournaments" :key="key">
                <div class="jumbotron">
                    <h1 class="display-4">
                        {{ tournament.tournament.name }}
                        <span class="badge badge-success" v-if="isTournamentFull(tournament)">
                            {{ tournament|countRegisterTournament }}
                        </span>
                        <span class="badge badge-danger" v-else>
                            {{ tournament|countRegisterTournament }}
                        </span>

                        <span class="badge badge-primary">
                            {{ tournament.tournament|timerTournament }} day(s) left
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
                    <b> {{ tournament.tournament|showDate }} </b>
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
                    
                    <div v-if="authenticated">
                        <p class="lead" v-if="tournament.registeredType == 'team' && hasTeamForTournament(tournament) && isTeamFull(tournament)">
                            <button class="btn btn-lg btn-success" v-if="!isTeamRegistered(tournament) && !isTournamentFull(tournament)" @click="registerTeam(tournament.tournament)" :disabled="loading">
                                <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
                                <i class="fas fa-plus" v-show="!loading"></i>
                                Register your team
                            </button>

                            <button class="btn btn-lg btn-danger" v-else-if="isTeamRegistered(tournament)" @click="unregisterTeam(tournament.tournament)" :disabled="loading">
                                <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
                                <i class="fas fa-minus" v-show="!loading"></i>
                                Unregister your team
                            </button>

                            <SiteBuyButton :user="user" :tournament="tournament.tournament"></SiteBuyButton>
                        </p>

                        <p class="lead" v-else-if="hasGameForTournament(tournament)">
                            <button class="btn btn-lg btn-success" v-if="!isPlayerRegistered(tournament) && !isTournamentFull(tournament)" @click="registerPlayer(tournament.tournament)" :disabled="loading">
                                <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
                                <i class="fas fa-plus" v-show="!loading"></i>
                                Register
                            </button>

                            <button class="btn btn-lg btn-danger" v-else-if="isPlayerRegistered(tournament)" @click="unregisterPlayer(tournament.tournament)" :disabled="loading">
                                <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
                                <i class="fas fa-minus" v-show="!loading"></i>
                                Unregister
                            </button>

                            <SiteBuyButton :user="user" :tournament="tournament.tournament" :alreadyPayed="alreadyPayed"></SiteBuyButton>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data() {
        return {
            loadingPage: false,
            loading: false,
            tournaments: [],
            playerTeams: [],
            playerGames: [],
            authenticated: auth.check(),
            user: null,
            alreadyPayed: false,
        }
    },

    methods: {
        getTournaments() {
            this.loadingPage = true
            axios.get('/api/tournaments/open')
            .then(response => {
                this.tournaments = response.data
                this.loadingPage = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
                this.loadingPage = false
            })
        },
        
        getUser() {
            axios.get('/api/user')
            .then(response => {
                this.user = response.data
                this.getPlayerTeams()
                this.getPlayerGames()
                this.checkPayment()
            })
        },

        getPlayerTeams() {
            this.loading = true

            axios.get('/api/players/' + this.user.id + '/teams')
            .then(response => {
                this.playerTeams = response.data
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        getPlayerGames() {
            this.loading = true

            axios.get('/api/players/' + this.user.id + '/games')
            .then(response => {
                this.playerGames = response.data
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        registerTeam(tournament) {
            this.loading = true
            let team = {}

            this.playerTeams.forEach(playerTeam => {
                if (playerTeam.team.game_id == tournament.game_id) {
                    team = playerTeam
                }
            })
            
            axios.put('/api/tournaments/' + tournament.id +'/register/teams/' + team.team.id)
            .then(response => {
                this.$noty.success("Your team has been successfully registered")
                this.getTournaments()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        unregisterTeam(tournament) {
            this.loading = true
            let team = {}

            this.playerTeams.forEach(playerTeam => {
                if (playerTeam.team.game_id == tournament.game_id) {
                    team = playerTeam
                }
            })
            
            axios.put('/api/tournaments/' + tournament.id +'/unregister/teams/' + team.team.id)
            .then(response => {
                this.$noty.success("Your team has been successfully unregistered")
                this.getTournaments()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        registerPlayer(tournament) {
            this.loading = true

            axios.put('/api/tournaments/' + tournament.id +'/register/players/' + this.user.id)
            .then(response => {
                this.$noty.success('You have been successfully registered')
                this.getTournaments()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        unregisterPlayer(tournament) {
            this.loading = true

            axios.put('/api/tournaments/' + tournament.id +'/unregister/players/' + this.user.id)
            .then(response => {
                this.$noty.success('You have been successfully unregistered')
                this.getTournaments()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        hasTeamForTournament(tournament) {
            let check = false
            this.playerTeams.forEach(team => {
                if (tournament.game.id == team.team.game_id) {
                    check = true
                }
            })

            return check
        },

        hasGameForTournament(tournament) {
            let check = false
            this.playerGames.forEach(game => {
                if (tournament.game.id == game.id) {
                    check = true
                }
            })

            if (check) {
                return true
            }

            return false
        },

        isPlayerRegistered(tournament) {
            let check = false
            this.tournaments.forEach(tournament => {
                if (tournament.registeredType == "player") {
                    tournament.registered.forEach(player => {
                        if (player.id == this.user.id) {
                            check = true
                        }
                    })
                }
            })
            
            return check
        },

        isTeamRegistered() {
            let check = false
            let team = {}

            this.tournaments.forEach(tournament => {
                if (tournament.registeredType == "team") {
                    tournament.registered.forEach(tournamentTeam => {
                        this.playerTeams.forEach(playerTeam => {
                            if (playerTeam.team.game_id == tournament.tournament.game_id) {
                                team = playerTeam
                            }
                        })

                        if (team && team.team.id == tournamentTeam.id) {
                            check = true
                        }
                    })
                }
            })

            return check
        },

        isTeamFull(tournament) {
            let check = false
            let team = {}

            this.playerTeams.forEach(playerTeam => {
                if (playerTeam.game_id == tournament.game_id) {
                    team = playerTeam
                }
            })

            if (team && team.players_count == tournament.game.places) {
                check = true
            }

            return check
        },

        isTournamentFull(tournament) {
            let check = false

            if (tournament.registered.length == tournament.tournament.places) {
                check = true
            }

            return check
        },

        checkPayment() {
            this.loading = true

            axios.get('/payment/check/player/' + this.user.id)
            .then(response => {
                if (response.data) {
                    this.alreadyPayed = true
                }
                else {
                    this.alreadyPayed = false
                }
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
            })
        },
    },

    filters: {
        countRegisterTournament(tournament) {
            return tournament.registered.length + ' / ' + tournament.tournament.places
        },

        showDate(tournament) {
            return moment(tournament.start_date).format('DD/MM/YYYY') + ' - ' + moment(tournament.end_date).format('DD/MM/YYYY')
        },

        timerTournament(tournament) {
            let now = moment()
            let tournamentDate = moment(tournament.start_date)
            let timeLeft = tournamentDate.diff(now, 'days')

            if (timeLeft <= 0) {
                return 0
            }
            else {
                return tournamentDate.diff(now, 'days')
            }
        }
    },

    mounted() {
        if (this.authenticated) {
            this.user = this.getUser()
        }

        this.getTournaments()
    }
}
</script>

<style>

</style>
