<template>
    <div>
        <admin-content-header page_name="Games" page_description="Manage your games"></admin-content-header>
        <FlashMessage position="right bottom"></FlashMessage>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Games
                            </h3>
                            <div class="box-tools pull-right">
                                <router-link :to="{ name: 'game.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                                <button class="btn btn-info" @click="getGames()">
                                    <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <AdminDataTable :data="games" :columns="columns"  :actions="actions" :index="false" :loading="loading"></AdminDataTable>
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
                {name: 'name', th: 'Name'},
                {name: 'description', th: 'Description'},
                {name: 'places', th: 'Players / Team'},
            ],
            actions: [
                {text: "", icon: "fas fa-eye", color: "primary btn-pill mr-2", action: (row, index) => {
                    this.$router.push({ name: 'game.show', params: {id: row.id} })
                }},
            ],
            games: [],
        }
    },

    methods: {
        getGames() {
            this.loading = true
            axios.get('/api/games')
            .then(response => {
                this.games = response.data
                this.loading = false
            })
        }
    },

    mounted() {
        this.getGames();
    }
}
</script>

<style>

</style>
