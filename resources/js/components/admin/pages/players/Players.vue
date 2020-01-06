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
                                <button class="btn btn-danger" @click="regenerateSecretKeys()" :disabled="loadingRegenerate">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loadingRegenerate }"></i>
                                    Regenerate secret keys
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <AdminDataTable :data="players" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
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
            columns: [
                {name: 'pseudo', th: 'Pseudo', render(row, cell, index) {
                    let adminIcon = ""

                    if (row.admin) {
                        adminIcon = "<span title='Admin' class='badge bg-green'><i class='fas fa-user-shield'></i></span>"
                    }

                    return adminIcon + ' ' + row.pseudo
                }},
                {name: 'email', th: 'Email'},
                {name: 'description', th: 'Description'},
            ],
            actions: [
                {text: "", icon: "fas fa-eye", color: "primary btn-pill mr-2", action: (row, index) => {
                    this.$router.push({ name: 'player.show', params: {id: row.id} })
                }},
            ],
            players: [],
            loadingRegenerate: false,
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
                        message: "The admin is now not visible"
                    })
                }
                else {
                    this.flashMessage.success({
                        title: "Visibility changed !",
                        message: "The admin is now visible"
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
        },

        regenerateSecretKeys() {
            this.loadingRegenerate = true
            axios.post('/api/players/regenerate/secret/keys')
            .then(response => {
                this.flashMessage.success({
                        title: "Keys regenerated",
                        message: response.data.message
                    })
                this.loadingRegenerate = false
            })
            .catch(e => {
                this.loadingRegenerate = false
                this.flashMessage.error({
                    title: "Something went wrong",
                    message: "Please try again"
                })
            })
        },
    },

    mounted() {
        this.getPlayers();
    }
}
</script>

<style>

</style>
