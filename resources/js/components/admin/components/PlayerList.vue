<template>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Players</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success" @click="addPlayer()">
                    <i class="fas fa-plus"></i>
                    Add
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-dark table-hover table-striped" id="players">
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
                            <button class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                            </button>
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
export default {
    props: [
        'players'
    ],

    data() {
        return {
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
        },

        deletePlayer(key) {
            this.players.splice(key,1) 
        }
    },
}
</script>

<style>

</style>
