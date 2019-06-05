<template>
    <div>
        <div class="row" v-show="loadingPage">
            <div class="col-lg-12 text-center" >
                <b-spinner style="width: 3rem; height: 3rem;" variant="dark" label="Loading"></b-spinner>
            </div>
        </div>

        <div class="row" v-show="!loadingPage" v-if="player.player">
            <div class="col-lg-4">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom text-center">
                        <div class="mb-3 mx-auto">
                            <img class="rounded-circle" :src="player.player.avatar" alt="User Avatar" width="110">
                        </div>
                        <h4 class="mb-0">{{ player.player.pseudo }}</h4>
                        <span class="text-muted d-block mb-2"> {{ player.player.description }} </span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-4">
                            <strong class="text-muted d-block mb-2"></strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs text-black">
                            <li class="nav-item">
                                <a class="nav-link active" id="informations-tab" data-toggle="tab" href="#informations" role="tab" aria-controls="informations" aria-selected="true">Informations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="true">Teams</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="games-tab" data-toggle="tab" href="#games" role="tab" aria-controls="games" aria-selected="true">Games</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Player informations -->
                            <div class="tab-pane active" id="informations" role="tabpanel" aria-labelledby="informations-tab">
                                <form action="POST" @submit.prevent="updatePlayer()">
                                    <div class="form-row" v-show="isUserProfile">
                                        <div class="form-group col-lg-6">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" v-model="player.player.name" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" v-model="player.player.email" disabled>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="pseudo">Pseudo</label>
                                            <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" v-model="player.player.pseudo" required :disabled="!isUserProfile">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="avatar">Avatar</label>
                                            <input type="url" name="avatar" id="avatar" class="form-control" placeholder="https://..." v-model="player.player.avatar" required :disabled="!isUserProfile">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label for="descirption">Description</label>
                                            <textarea name="descirption" id="descirption" rows="3" class="form-control" style="resize: none;" v-model="player.player.description" :disabled="!isUserProfile"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success" :disabled="loading" v-show="isUserProfile">
                                        <i class="fas fa-sync-alt fa-spin" v-show="loading"></i>
                                        <i class="fas fa-check" v-show="!loading"></i>
                                        Update
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Player teams -->
                            <div class="tab-pane" id="teams" role="tabpanel" aria-labelledby="teams-tab">
                                <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#createTeam" v-show="isUserProfile">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </button>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Game</th>
                                            <th scope="col" class="text-center" v-show="isUserProfile">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(team, key) in player.teams" :key="key">
                                            <td> {{ team.name }} </td>
                                            <td> {{ team.game.name }} </td>
                                            <td class="text-center" v-show="isUserProfile">
                                                <router-link :to="{name: 'team.show', params: {id: team.id}}" class="btn btn-sm btn-pill btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </router-link>

                                                <button class="btn btn-sm btn-pill btn-danger" @click="deleteTeam(team.id)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Player games -->
                            <div class="tab-pane" id="games" role="tabpanel" aria-labelledby="games-tab">
                                <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#addGame" v-show="isUserProfile">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </button>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <!-- <th scope="col">Rank</th> -->
                                            <th scope="col" class="text-center" v-show="isUserProfile">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(game, key) in player.games" :key="key">
                                            <td> {{ game.name }} </td>
                                            <!-- <td></td> -->
                                            <td class="text-center" v-show="isUserProfile">
                                                <!-- <button class="btn btn-sm btn-pill btn-success" data-toggle="modal" data-target="#editGame" v-show="isUserProfile" @click="editGame(game.id)">
                                                    <i class="fas fa-edit"></i>
                                                </button> -->

                                                <button class="btn btn-sm btn-pill btn-danger" @click="deleteGame(game.id)">
                                                    <i class="fas fa-trash-alt"></i>
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
        </div>



        <site-modal id="createTeam" header="Create team" confirmButton="Create" @clicked="addTeam()">
            <form>
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" v-model="newTeam.name" required>
                    </div>
                    
                    <div class="form-group col-lg-12">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" v-model="newTeam.description" required></textarea>
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="game_id">Game</label>
                        <select name="game_id" id="game_id" class="form-control" v-model="newTeam.game_id" required>
                            <option selected disabled>-- Please choose a game --</option>
                            <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                        </select>
                    </div>
                </div>
            </form>
        </site-modal>

        <site-modal id="addGame" header="Add Game" confirmButton="Add" @clicked="addGame()">
            <form>
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <label for="game_id">Game</label>
                        <select name="game_id" id="game_id" class="form-control" v-model="gameSelected" required>
                            <option selected disabled>-- Please choose a game --</option>
                            <option :value="game.id" v-for="(game, key) in games" :key="key"> {{ game.name }} </option>
                        </select>
                    </div>
                </div>
            </form>
        </site-modal>

        <site-modal id="editGame" header="Edit Game" confirmButton="Update" @clicked="updateGame()">
            <form>
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <label for="game_id">Rank</label>
                        <select name="game_id" id="game_id" class="form-control" v-model="rankSelected" required>
                            <option selected disabled>-- Please choose your --</option>
                            <option :value="rank.id" v-for="(rank, key) in gameRanks" :key="key"> {{ rank.name }} </option>
                        </select>
                    </div>
                </div>
            </form>
        </site-modal>
    </div>
</template>

<script>
import SiteModal from './../../layouts/SiteModal'

export default {
    components: {
        SiteModal,
    },

    data() {
        return {
            user: {},
            loadingPage: false,
            loading: false,
            player: {},
            games: [],
            gameRanks: [],
            gameSelected: null,
            rankSelected: null,
            newTeam: {
                name: '',
                description: '',
                game_id: null,
                avatar: '',
                captain_id: this.$route.params.id,
            },
        }
    },

    methods: {
        getUser() {
            this.loadingPage = false
            axios.get('/api/user')
            .then(response => {
                this.user = response.data
                this.loadingPage = false
            })
            .catch(() => {
                this.loadingPage = false
            })
        },

        getPlayer() {
            this.loadingPage = true

            axios.get('/api/players/' + this.$route.params.id)
            .then(response => {
                this.player = response.data
                this.loadingPage = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
                this.loadingPage = false
            })
        },

        getGames() {
            axios.get('/api/games')
            .then(response => {
                this.games = response.data
            })
        },

        updatePlayer() {
            this.loading = true
            axios.put('/api/players/' + this.$route.params.id, this.player.player)
            .then(response => {
                this.$noty.success("Parameters updated !")
                this.loading = false
            })
            .catch(response => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        addTeam() {
            this.loading = true
            axios.post('/api/teams', this.newTeam)
            .then(response => {
                this.$noty.success("Team created !")
                this.getPlayer()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try reload the page")
                this.loading = false
            })
        },

        deleteTeam(id) {
            if (confirm("Are you sure you want to delete this team ?")) {
                this.loading = true
                axios.delete('/api/teams/' + id)
                .then(() => {
                    this.$noty.success("Team deleted !")
                    this.getPlayer()
                    this.loading = false
                })
                .catch(() => {
                    this.$noty.error("Something went wrong... Try reload the page")
                    this.loading = false
                })
            }
        },

        addGame() {
            this.loading = true
            axios.post('/api/players/' + this.player.player.id + '/game', { game_id: this.gameSelected})
            .then(response => {
                this.$noty.success("Parameters updated !")
                this.getPlayer()
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        },

        editGame(id) {
            this.getGameRanks(id)
        },

        updateGame(id) {
        },

        deleteGame(id) {
            if (confirm("Are you sure you want to delete this game ?")) {
                this.loading = true
                axios.delete('/api/players/' + this.player.player.id + '/game', {game_id: id})
                .then(response => {
                    this.$noty.success("Game deleted !")
                    this.getPlayer()
                    this.loading = false
                })
                .catch(() => {
                    this.$noty.error("Something went wrong... Try again")
                    this.loading = false
                })
            }
        },

        getGameRanks(id) {
            this.loading = true
            axios.get('/api/games/' + id + '/ranks')
            .then(response => {
                this.gameRanks = response.data
                this.loading = false
            })
            .catch(() => {
                this.$noty.error("Something went wrong... Try again")
                this.loading = false
            })
        }
    },

    computed: {
        isUserProfile() {
            if (this.user.id == this.player.player.id) {
                return true
            }
            return false
        }
    },

    mounted() {
        this.getUser()
        this.getPlayer()
        this.getGames()
    }
}
</script>

<style>

</style>
