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
                                <router-link :to="{ name: 'game.create'}" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </router-link>
                            </h3>
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
                                        <td>{{ game.place }}</td>
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
            games: [
                { id: 1, name: "CS:GO", description: "An amazing FPS shooter", place: 5 },
                { id: 2, name: "ForHonor", description: "Now you are an ultimate warrior", place: 4 },
            ],
        }
    },

    methods: {
        
    },
}
</script>

<style>

</style>
