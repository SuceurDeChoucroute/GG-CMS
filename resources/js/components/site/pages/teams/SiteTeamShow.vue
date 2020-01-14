<template>
    <div>
        <div class="row" v-show="loading">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <div class="row" v-show="!loading" v-if="team.team">
            <div class="col-lg-5">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom text-center">
                        <div class="mb-3 mx-auto">
                            <img class="rounded-circle" :src="team.team.avatar" alt="User Avatar" width="110">
                        </div>
                        <h4 class="mb-0">{{ team.team.name }}</h4>
                        <span class="text-muted d-block mb-2"> {{ team.team.description }} </span>

                        <div v-if="!isCaptainTeam()">
                            <button class="btn btn-danger" v-if="isPlayerAlreadyHasJoinRequest(team.team) || requestAlreadySend" disabled> Demande déjà envoyée</button>
                            
                            <button type="button" class="btn btn-success" v-else-if="user && !isTeamFull()" @click="sendJoinRequest()" :disabled="loadingButton">
                                <i class="fas fa-sync-alt fa-spin" v-show="loadingButton"></i>
                                <i class="fas fa-plus" v-show="!loadingButton"></i> Rejoindre
                            </button>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-4">
                            <strong class="text-muted d-block mb-2">Nos participation(s):</strong>
                            <ul>
                                <li v-for="(participation, key) in team.participations" :key="key"> {{ participation.name }} </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                        <h6 class="m-0">Joueurs de l'équipe</h6>
                    </div>
                    <div class="card-body p-0 text-center">
                        <table class="table mb-0 table-hover">
                            <thead class="bg-light" v-if="isCaptainTeam()">
                                <tr>
                                    <th scope="col" class="text-white border-0">Joueur</th>
                                    <th scope="col" class="text-white border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(player, key) in team.players" :key="key + '-player'">
                                    <td>
                                        <i class="fas fa-star text-warning" v-if="player.pivot.captain"></i> 
                                        <router-link :to="{name: 'player.show', params: {id: player.id}}"> {{ player.pseudo }} </router-link> 
                                    </td>

                                    <td v-if="!player.pivot.captain && isCaptainTeam()">
                                        <button class="btn btn-pill btn-sm btn-danger" @click="deletePlayer(player)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td v-else></td>
                                    
                                    <td v-if="team.joinrequests.players.length">
                                    </td>
                                </tr>

                                <tr v-for="(player, key) in team.joinrequests.players" :key="key + '-playerRequest'">
                                    <td v-if="isCaptainTeam()">
                                        <router-link :to="{name: 'player.show', params: {id: player.id}}"> {{ player.pseudo }} </router-link>    
                                    </td>
                                    <td v-if="isCaptainTeam()">
                                        <button class="btn btn-success" @click="acceptRequest(player)" :disabled="loadingButton">
                                            <i class="fas fa-sync-alt fa-spin" v-show="loadingButton"></i>
                                            Accepter
                                        </button>
                                        <button class="btn btn-danger" @click="refuseRequest(player)" :disabled="loadingButton">
                                            <i class="fas fa-sync-alt fa-spin" v-show="loadingButton"></i>
                                            Refuser
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            loadingButton: false,
            requestAlreadySend: false,
            team: {},
            playerJoinRequests: [],
            authenticated: auth.check(),
            user: null,
        }
    },

    methods: {
        getTeam() {
            this.loading = true
            axios.get('/api/teams/' + this.$route.params.id)
            .then(response => {
                this.team = response.data
                this.loading = false
            })
            .then(() => {
                this.loading = false
            })
        },

        getUser() {
            axios.get('/api/user')
            .then(response => {
                this.user = response.data
                this.getPlayerJoinRequests()
            })
        },

        getPlayerJoinRequests() {
            axios.get('/api/players/' + this.user.id + '/joinrequests')
            .then(response => {
                this.playerJoinRequests = response.data
            })
            .catch(() => {
                // this.$noty.error('Something went wrong... Try again')
            })
        },

        deletePlayer(player) {
            this.loading = true

            axios.delete('/api/teams/' + this.team.team.id + '/delete/player/' + player.id)
            .then(response => {
                this.$noty.success(response.data.message)
                this.getTeam()
                this.loading = false
            })
            .catch(response => {
                this.$noty.error(response.data.message)
                this.loading = false
            })
        },

        sendJoinRequest() {
            this.loadingButton = true
            axios.post('/api/teams/' + this.$route.params.id+ '/joinrequest/' + this.user.id)
            .then(response => {
                this.$noty.success(response.data.message)
                this.requestAlreadySend = true
                this.loadingButton = false
            })
            .catch(error => {
                if (error.response.status == 401) {
                    this.$noty.error("Vous avez déjà envoyé une demande")
                }
                else {
                    // this.$noty.error("Something went wrong... Try again")
                }
                
                this.loadingButton = false
            })
        },

        acceptRequest(player) {
            this.loadingButton = true
            axios.post('/api/teams/' + this.$route.params.id+ '/joinrequest/' + player.id + '/accept')
            .then(response => {
                this.$noty.success(response.data.message)
                this.getTeam()
                this.loadingButton = false
            })
            .catch(() => {
                // this.$noty.error("Something went wrong... Please try again")
                this.loadingButton = false
            })
        },

        refuseRequest(player) {
            this.loadingButton = true
            axios.post('/api/teams/' + this.$route.params.id+ '/joinrequest/' + player.id + '/refuse')
            .then(response => {
                this.$noty.success(response.data.message)
                this.getTeam()
                this.loadingButton = false
            })
            .catch(() => {
                // this.$noty.error("Something went wrong... Please try again")
                this.loadingButton = false
            })
        },

        isPlayerAlreadyHasJoinRequest(team)
        {
            let check = false

            this.playerJoinRequests.forEach(joinrequest => {
                if (joinrequest.team_id == team.id) {
                    check = true
                    this.requestAlreadySend = true
                }
            })

            return check
        },

        isCaptainTeam()
        {
            let check = false

            if (this.user) {
                this.team.players.forEach(player => {
                    if (player.pivot.captain == 1) {
                        if (player.id == this.user.id) {
                            check = true
                        }
                    }
                })
            }

            return check
        },

        isTeamFull() {
            if (this.team.game.places > this.team.players.length) {
                return false
            }
            else {
                return true
            }
        }
    },

    mounted() {
        if (this.authenticated) {
            this.user = this.getUser()
        }

        this.getTeam()
    }
}
</script>

<style>

</style>
