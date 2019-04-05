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
                                <button class="btn btn-success" @click="addPlayer()">
                                    <i class="fas fa-plus"></i>
                                    Add
                                </button>
                            </h3>
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
                                    <tr v-for="(player, key) in players" :key="key">
                                        <td>{{ player.name }}</td>
                                        <td>{{ player.email }}</td>
                                        <td>{{ player.description }}</td>
                                        <td>
                                            <router-link :to="{ name: 'player.show', params: {id: player.id} }" class="btn btn-primary">
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
import AdminContentHeader from './../layouts/AdminContentHeader'
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        AdminContentHeader,
        Loader
    },
    data() {
        return {
            loading: false,
            player: {
                id: 10,
                name: "Pepito",
                email: "pepito@example.com",
                description: "Mucho pepito",
            },
            players: [
                {id: 1, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 2, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 6, name: 'Gotaga'  , email: 'gotaga@example.com', description: "The french monster !"},
                {id: 3, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 4, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
                {id: 5, name: 'John Doe', email: 'john.doe@example.com', description: "I'm the best and i know it !"},
            ],
        }
    },

    methods: {
        addPlayer() {
            this.players.push(this.player)
            this.flashMessage.success({
                title: "Players added !",
                message: "The player has been successfully added"
            })
        },
    },
}
</script>

<style>

</style>
