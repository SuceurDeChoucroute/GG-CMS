<template>
    <div class="box box-primary">
        <FlashMessage position="right bottom"></FlashMessage>
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
                            <button class="btn btn-danger" @click="deletePlayer(key)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Loader from 'vue-spinner/src/ScaleLoader.vue'

export default {
    components: {
        Loader
    },

    props: [
        'players'
    ],

    data() {
        return {
            loading: false,
            player: {
              id: 10,
              name: "Pepito",
              email: "pepito@example.com",
              description: "Mucho pepito",
          }
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

        deletePlayer(key) {
            this.players.splice(key,1)

            this.flashMessage.success({
                title: "Players deleted !",
                message: "The player has been successfully deleted"
            })
            // this.flashMessage.error({
            //     title: "Something went wrong",
            //     message: "Please try again"
            // })
        }
    },
}
</script>

<style>

</style>
