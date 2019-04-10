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
                            <loader :color="'#337ab7'" v-show="loading"></loader>
                            <table class="table table-dark table-hover table-striped" id="games" v-show="!loading">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Players / Team</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(game, key) in games" :key="key">
                                        <td>{{ game.name }}</td>
                                        <td>{{ game.description }}</td>
                                        <td>{{ game.places }}</td>
                                        <td>
                                            <router-link :to="{ name: 'game.show', params: {id: game.id} }" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            
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
