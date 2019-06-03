<template>
    <div>
        <admin-content-header page_name="Players" page_description="Manage your players"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Players
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'player.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                                <button class="btn btn-info" @click="getPlayers()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <table class="table table-dark table-hover table-striped" id="players" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Pseudo</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!players.length">
                                        <td colspan="4" class="text-center"> No players registered ... </td>
                                    </tr>
                                    <tr v-else v-for="(player, key) in players" :key="key">
                                        <td>
                                            <span v-show="player.admin" class="badge bg-green" title="Admin"><i class="fas fa-user-shield"></i></span>
                                            {{ player.pseudo }}
                                        </td>
                                        <td>{{ player.email }}</td>
                                        <td>{{ player.description }}</td>
                                        <td>
                                            <router-link :to="{ name: 'player.show', params: {id: player.id} }" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>

                                            <button v-show="player.admin" class="btn btn-danger" @click="revokeAdmin(key)" title="Revoke all admin rights, the account will not be deleted">
                                                <i class="far fa-times-circle"></i>
                                            </button>

                                            <button v-show="!player.admin" class="btn btn-success" @click="grantAdmin(key)" title="Grant player to admin">
                                                <i class="fas fa-arrow-alt-circle-up"></i>
                                            </button>

                                            <button v-show="player.admin" :class="{ 'btn btn-danger': player.visibility, 'btn btn-success': !player.visibility}" @click="changeVisibility(key)" title="Change admin visibility">
                                                <i class="fas fa-eye-slash" v-if="player.visibility"></i>
                                                <i class="fas fa-eye" v-else></i>
                                            </button>
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
            players: [],
            admins: [],
        }
    },

    methods: {
        getPlayers() {
            this.loading = true
            axios.get('/api/players')
            .then(response => {
                this.players = response.data
                this.loading = false
            })
        },

        getAdmins() {
            this.loading = true
            axios.get('/api/players/admins')
            .then(response => {
                this.admins = response.data
                this.loading = false
            })
        },

        // Revoke admin
        revokeAdmin(key) {
            if (confirm('Are you sure you want to revoke this admin ?')) {
                this.loading = true

                if (this.admins.length != 1) {
                    axios.post('/api/players/'+ this.players[key].id +'/revokeAdmin')
                    .then(response => {
                        this.players[key].admin = 0;
                        this.flashMessage.success({
                            title: "Admin revoked !",
                            message: "The admin has been successfully revoked"
                        })
                        
                        // Update admins list
                        this.getPlayers();

                        this.loading = false
                    })
                    .catch(e => {
                        this.flashMessage.error({
                            title: "Something went wrong",
                            message: "Please try again"
                        })
                        this.loading = false
                    })
                }
                else {
                    this.flashMessage.error({
                        title: "Impossible to revoke !",
                        message: "You can't revoke the only admin"
                    })
                    this.loading = false
                }
            }
        },

        // Grant admin
        grantAdmin(key) {
            if (confirm('Are you sure you want to grant this player to admin ?')) {
                this.loading = true
                
                axios.post('/api/players/'+ this.players[key].id +'/grantAdmin')
                .then(response => {
                    this.players[key].admin = 1;
                    this.flashMessage.success({
                        title: "Player granted !",
                        message: "The player has been successfully granted to admin"
                    })

                    // Update admins list
                    this.getPlayers();

                    this.loading = false
                })
                .catch(e => {
                    this.flashMessage.error({
                        title: "Something went wrong",
                        message: "Please try again"
                    })
                    this.loading = false
                })
            }
        },

        changeVisibility(key)
        {
            this.loading = true
            axios.post('/api/players/' + this.players[key].id + '/visibility')
            .then(response => {
                this.loading = false
                this.getPlayers()
                if (this.players[key].visibility) {
                    this.flashMessage.success({
                        title: "Visibility changed !",
                        message: "The admin is now visible"
                    })
                }
                else {
                    this.flashMessage.success({
                        title: "Visibility changed !",
                        message: "The admin is now not visible"
                    })
                }
            })
            .catch(e => {
                this.loading = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        }
    },

    mounted() {
        this.getPlayers();
    }
}
</script>

<style>

</style>
